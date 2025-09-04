# Test Plan: PHP Security Demo

## Overview
This project contains both manual and automated tests to verify the functional
behavior of the demo pages and to demonstrate where XSS is possible and where
it is prevented.

## Automated tests (what they check)
- `tests/test_xss.py` — lightweight HTTP tests (requests) that verify the
  vulnerable endpoints reflect payloads and that the safe endpoint returns the
  escaped payload text.
- `tests/test_selenium_xss.py` — headless browser tests that exercise the
  user flows and assert whether an alert popup is triggered where expected.

## How the automated fixture works
- `tests/conftest.py` includes a guarded fixture that will attempt to:
  1. Build the Docker image `basic-php-server`.
  2. Start a container named `php-security-demo-test` mapped to `localhost:8080`.
  3. Wait for the site to return HTTP 200.
  4. Run the tests and remove the container afterwards.

The fixture auto-skips tests with a clear message if Docker is not available or
if the current user cannot access the Docker daemon.

## Running the automated tests (developer)
- See `tests/README.md` for a step-by-step guide (venv set up, docker group
  guidance, and commands). The quick run is:

```bash
# inside venv
pytest tests/ --maxfail=5 -q
# or if your shell hasn't picked up docker group membership yet
sg docker -c "source venv/bin/activate && pytest tests/ --maxfail=5 -q"
```

## Manual testing
- Use the `EXERCISES.md` worksheet and the lesson worksheet in `WORKSHEET.md` to
  step students through manual payloads and comparison of safe vs vulnerable
  outputs.

## Troubleshooting
- If the fixture times out waiting for the site, check container logs with:

```bash
docker logs php-security-demo-test
```

- Ensure no other service is binding port 8080. Stop any conflicting container
  before running tests.

