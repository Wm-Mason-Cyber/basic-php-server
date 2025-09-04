# Student Exercises & Discussion

This page provides a short lesson plan and hands-on tasks you can use in a
single lab session (30–60 minutes) to teach reflected XSS.

## Setup (Instructor)
- Start the site locally (see project README). Confirm `http://localhost:8080/`
	is reachable from students' machines or the classroom network.

## Hands-On Lab (30–45 minutes)

1) Exploratory tasks (10 minutes)
- Visit `Contact` and `Vulnerable` pages and submit normal text.
- Try entering an HTML tag like `<b>bold</b>` in the form fields. What happens?

2) Trigger a simple XSS alert (10 minutes)
- Enter this payload into the name or search box:

```
<script>alert('XSS')</script>
```

- Observe where the alert pops up. Discuss why it appears on some pages and
	not others.

3) Compare safe vs vulnerable (10 minutes)
- Submit the same payload to `safe.php`. What happens? Why?
- Inspect `safe.php` and find the `htmlspecialchars()` usage.

4) Code exploration (optional, 10–20 minutes)
- Have students modify `safe.php` to remove the escaping and re-run the
	submission to see the difference.

## Discussion Questions (classroom)
- What is Cross-Site Scripting (XSS)? How is reflected XSS different from
	persistent XSS?
- Why is output escaping important even when you validate input?
- When should `htmlspecialchars()` be used? Are there other approaches?
- What are safe coding patterns when handling user input for HTML content?

## Instructor notes and safety
- Remind students this code is intentionally vulnerable and should not be
	published to the open internet.
- If students work on shared machines, ensure the classroom network is
	isolated during the lab.
- Collect copies of interesting payloads and use them to discuss how attackers
	might exploit similar flaws.

## Further exercises
- Extend the site with a new form and practice escaping output.
- Explore HTML-encoding differences, attribute contexts, and event handler
	injection.
- Research other web security topics: SQLi, CSRF, authentication issues.

## New demos: Stored XSS and SQL Injection

Stored XSS:
- Visit `Stored-XSS (Vuln)` and `Stored-XSS (Safe)` from the navigation.
- Post a message containing `<script>alert('XSS')</script>` to the vulnerable board
  and observe the alert appear for any subsequent page viewers.
- Compare to the safe board, which escapes output and shows the payload as text.

SQL Injection:
- Visit `SQLi (Vuln)` and `SQLi (Safe)`.
- Try searching for a name like `Alice` and then try a classic test such as
  `%' OR '1'='1` in the vulnerable page to see how naive concatenation can
  change the query results. Discuss why the safe page using prepared
  statements prevents this.

Instructor note: both demos use a local `data/` directory and an SQLite file. The
data is isolated to the project directory; remove `data/` to reset state.
