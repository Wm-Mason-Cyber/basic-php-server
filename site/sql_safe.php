<?php include 'nav.php'; ?>
<?php require_once __DIR__ . '/../src/helpers.php'; ?>
<div class="container">
  <h1>SQL Injection — Safe Demo</h1>
  <p>Same as the vulnerable demo, but uses prepared statements to avoid SQLi.</p>

  <form method="get" action="sql_safe.php">
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
    // Use prepared statement to avoid injection
    $stmt = $db->prepare('SELECT id, name FROM users WHERE name LIKE :name');
    $stmt->bindValue(':name', '%' . $name . '%', SQLITE3_TEXT);
    $res = $stmt->execute();
    echo "<h2>Results</h2><ul>";
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      echo "<li>" . html_escape((string)$row['id']) . ": " . html_escape($row['name']) . "</li>";
    }
    echo "</ul>";
  }
  ?>
</div>
