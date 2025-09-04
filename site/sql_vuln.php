<?php include 'nav.php'; ?>
<div class="container">
  <h1>SQL Injection — Vulnerable Demo</h1>
  <p>This demo uses a tiny SQLite database and constructs SQL with string
  concatenation (vulnerable). It's intentionally local and file-based.</p>

  <form method="get" action="sql_vuln.php">
    <label for="name">Search name:</label>
    <input id="name" name="name" />
    <button type="submit">Search</button>
  </form>

  <?php
  $datadir = __DIR__ . '/../data';
  @mkdir($datadir);
  $dbfile = $datadir . '/demo.db';
  $init = !file_exists($dbfile);
  $db = new SQLite3($dbfile);
  if ($init) {
    $db->exec('CREATE TABLE users(id INTEGER PRIMARY KEY, name TEXT)');
    $db->exec("INSERT INTO users(name) VALUES('Alice'),('Bob'),('Mallory')");
  }

  if (isset($_GET['name'])) {
    $name = $_GET['name'];
    // Vulnerable concatenation — do NOT do this in production
    $sql = "SELECT id, name FROM users WHERE name LIKE '%" . $name . "%'";
    $res = $db->query($sql);
    echo "<h2>Results</h2><ul>";
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      echo "<li>" . $row['id'] . ": " . $row['name'] . "</li>";
    }
    echo "</ul>";
  }
  ?>
</div>
