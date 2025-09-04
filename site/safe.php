<?php include 'nav.php'; ?>
<div class="container">
  <h1>Safe Search</h1>
  <form method="get" action="safe.php">
    <label for="q">Search:</label>
    <input type="text" id="q" name="q">
    <button type="submit">Search</button>
  </form>
  <?php
  // Safe: output is escaped
  if (isset($_GET['q'])) {
    $safe = htmlspecialchars($_GET['q'], ENT_QUOTES, 'UTF-8');
    echo "<p>Results for: " . $safe . "</p>";
    echo "<p style='color:green;'>This page safely escapes user input using htmlspecialchars().</p>";
  }
  ?>
</div>
