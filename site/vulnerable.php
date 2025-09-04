<?php include 'nav.php'; ?>
<div class="container">
  <h1>Vulnerable Search</h1>
  <form method="get" action="vulnerable.php">
    <label for="q">Search:</label>
    <input type="text" id="q" name="q">
    <button type="submit">Search</button>
  </form>
  <?php
  // Intentionally vulnerable to reflected XSS
  if (isset($_GET['q'])) {
    echo "<p>Results for: " . $_GET['q'] . "</p>";
    echo "<p style='color:red;'>This page is intentionally vulnerable to XSS. Try searching for &lt;script&gt;alert('XSS')&lt;/script&gt;.</p>";
  }
  ?>
</div>
