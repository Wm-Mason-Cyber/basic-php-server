## Running the test suite (quick guide)

This project includes a small pytest-based test suite that exercises the demo PHP site.
The tests can automatically build and run a Docker container for the site when the test runner
has access to the Docker daemon.

This document shows the minimal, repeatable steps to run the tests inside a Python
virtual environment when your user is in the `docker` group.

Prerequisites
- Python 3.10+ and `python3 -m venv` available
- Docker installed on the machine
- Your user added to the `docker` group (so `docker ps` works without sudo)

Quick start (recommended)

1. Create and activate a venv (one-time):

```bash
python3 -m venv venv
source venv/bin/activate
```

2. Install test dependencies (inside the venv):

```bash
pip install -r tests/requirements.txt
```

3. Ensure your shell session recognizes the `docker` group membership.
   - If you just had your user added to the `docker` group, either log out and
     log back in, or run:

```bash
newgrp docker
# or run single commands with effective docker group:
# sg docker -c "<command>"
```

4. Run the tests (simple):

```bash
# If your current shell already shows `docker` in `id -nG`:
pytest tests/ --maxfail=5 -q

# If you haven't re-logged in, run pytest under the docker group temporarily:
sg docker -c "source venv/bin/activate && pytest tests/ --maxfail=5 -q"
```

Notes and troubleshooting
- The test fixture will attempt to build the Docker image `basic-php-server` and
  run a container on localhost:8080 for the test run and will remove it afterward.
- If you get "permission denied" when calling `docker` from your shell, make sure
  your user is in the `docker` group and your session picked up that change.
- If the test fixture cannot start the container (port 8080 is already in use),
  stop the conflicting container or change the port mapping (edit `tests/conftest.py`).
- To run tests in CI, ensure the runner environment has Docker available and
  permissions (or consider running the tests inside a Docker-in-Docker executor).

Optional: make automation opt-in
- By default the fixture will try to manage Docker automatically when possible.
  If you prefer to make automation opt-in, change the fixture to run only when
  an environment variable (for example `CI_DOCKER_AUTOMATION=1`) is set.

That's it — if anything fails, copy the `pytest` output and the Docker container logs (they appear in the test output when readiness fails) and I can help debug.
