# basic-php-server

A small, classroom-friendly PHP + Apache demo site intentionally built to
teach web fundamentals and a focused security concept: reflected Cross-Site
Scripting (XSS).

This repository provides:
- A minimal PHP site (under `site/`) with a vulnerable contact page and
	vulnerable/search examples, and a safe example that uses `htmlspecialchars()`.
- A Dockerfile that packages the site on `php:8.2-apache` for easy, reproducible
	local runs.
- Automated tests (pytest + requests + Selenium) that can verify the presence
	or absence of XSS, and a small fixture to build and run the container while
	tests execute.
- Classroom-ready documentation and a printable lesson worksheet in `docs/`.
 - A small PHP helpers library (`src/helpers.php`), a CLI demo script
	 (`bin/demoscript.php`), and a tiny API endpoint (`site/api.php`) that
	 demonstrate safe escaping and simple PHP patterns for students.

Why this exists
- Teach how PHP and Apache serve dynamic content.
- Demonstrate how reflected XSS works (and how to fix it).
- Provide a safe, local sandbox students can use to experiment.

Quick start
1. Build and run with Docker (recommended):

```bash
# build the image (from repo root)
docker build -t basic-php-server .

# run the site on http://localhost:8080
docker run --rm -p 8080:80 basic-php-server
```

2. Open your browser at http://localhost:8080/ and explore `Contact`,
	 `Vulnerable` and `Safe` pages.

Running tests (developer-friendly)
- See `tests/README.md` for precise instructions. The test suite can build and
	tear down a Docker container automatically if the test runner has access to the
	Docker daemon (the fixture checks for Docker and will skip tests with a clear
	message if it is not available).

Safety and teaching notes
- This project intentionally includes *vulnerable* code for educational purposes only.
- Do not deploy this code to a public server.
- When teaching, control access to the network and have students run the site
	locally or in an isolated classroom network.

Documentation and lesson materials
- See `docs/PROJECT_GOALS.md`, `docs/EXERCISES.md`, `docs/TEST_PLAN.md` and
	the lesson worksheet `docs/WORKSHEET.md` for goals, exercises, tests, and a
	printable worksheet for students.

Contributing
- Report issues or suggest improvements via pull requests. Keep changes
	focused on clarity and safety for classroom use.

