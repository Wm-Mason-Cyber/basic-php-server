# Project Goals: PHP Security Demo

This repository contains a deliberately small PHP website intended for classroom
use. The code is intentionally minimal so students can read, modify, and test it
quickly.

## Primary Teaching Goals
- Explain how PHP runs on Apache and how dynamic page rendering works.
- Show how user input flows from HTML forms to server-side output.
- Demonstrate reflected Cross-Site Scripting (XSS) vulnerabilities in a
	controlled environment.
- Demonstrate how to fix reflected XSS using output escaping in PHP
	(for example, `htmlspecialchars()`).

## Secondary Goals
- Provide automated tests so instructors can validate student work.
- Provide a Docker-based workflow for reproducible runs in classroom machines.
- Provide a short worksheet and exercises that guide classroom activities.

## Functional Requirements
- All pages include a common navigation and consistent styling.
- `contact.php` submits via GET to `submit.php`; `submit.php` intentionally
	reflects values unsafely for teaching purposes.
- `vulnerable.php` is a simple search page that reflects the `q` parameter
	without escaping.
- `safe.php` performs correct escaping with `htmlspecialchars()` and shows the
	difference to students.

## Security Requirements (teacher note)
- The vulnerable files (`submit.php`, `vulnerable.php`) intentionally reflect
	unescaped user input. Do not reuse these patterns outside of the classroom.
- The safe example (`safe.php`) uses `htmlspecialchars()` to prevent reflected
	XSS. Discuss other mitigations and when they are appropriate.

## Testing Requirements
- Include automated tests (requests + Selenium) to demonstrate vulnerabilities
	and protections. These tests are meant for instructor validation, not student
	grading automation.

## Teacher guidance
- Always run the site locally behind a firewall or in an isolated network for
	classroom exercises.
- Encourage students to modify the safe page to see how escaping functions.
- Emphasize responsible disclosure and why code with vulnerabilities must not be
	deployed publicly.
