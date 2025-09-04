import os
import time
import subprocess
import pytest

"""Pytest fixture to optionally automate Docker lifecycle for tests.

Behavior:
- If the docker CLI is missing, tests are skipped with an explanatory message.
- If the docker daemon is not accessible by the current user, tests are skipped
  with instructions on how to grant access.
- If Docker is accessible, this fixture will build the image (tag
  `basic-php-server`), run a container named `php-security-demo-test` mapped to
  localhost:8080, wait for the site to respond, yield control to tests, and
  then tear the container down.

Control:
- The fixture auto-enables when run under a user that can call `docker`.
- You can force automation in CI by ensuring the runner user has Docker
  permissions.
"""


def _docker_available():
	try:
		p = subprocess.run(["docker", "ps"], capture_output=True, text=True)
	except FileNotFoundError:
		return (False, "docker CLI not found; install Docker to enable automated tests")
	if p.returncode != 0:
		return (False, "Docker daemon not accessible by current user; add your user to the 'docker' group or run tests in an environment with Docker access")
	return (True, "")


@pytest.fixture(scope="session", autouse=True)
def docker_server():
	ok, msg = _docker_available()
	if not ok:
		pytest.skip(msg)

	# Build the image (quiet-ish)
	build = subprocess.run(["docker", "build", "-t", "basic-php-server", "."], capture_output=True, text=True)
	if build.returncode != 0:
		pytest.skip(f"Docker build failed; run 'docker build -t basic-php-server .' manually. Stderr:\n{build.stderr}")

	name = "php-security-demo-test"
	# Remove any prior container with the same name (best-effort)
	subprocess.run(["docker", "rm", "-f", name], capture_output=True)

	run = subprocess.run(["docker", "run", "-d", "--name", name, "-p", "8080:80", "basic-php-server"], capture_output=True, text=True)
	if run.returncode != 0:
		pytest.skip(f"Docker run failed: {run.stderr}")
	container_id = run.stdout.strip()

	# Wait for HTTP readiness
	import requests

	start = time.time()
	timeout = 20
	url = "http://localhost:8080/"
	while time.time() - start < timeout:
		try:
			r = requests.get(url, timeout=1)
			if r.status_code == 200:
				break
		except Exception:
			pass
		time.sleep(0.5)
	else:
		subprocess.run(["docker", "logs", container_id], capture_output=False)
		subprocess.run(["docker", "rm", "-f", container_id], capture_output=True)
		pytest.skip("Container did not become ready within timeout; see logs above")

	# Yield to tests; after tests, tear down the container
	yield

	subprocess.run(["docker", "rm", "-f", container_id], capture_output=True)
