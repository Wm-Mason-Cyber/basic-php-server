<?php include 'nav.php'; ?>
<div class="container">
  <h1>Stored XSS — Vulnerable Message Board</h1>
  <p>This page stores posted messages and displays them without escaping —
  intentionally vulnerable so students can observe stored XSS.</p>

  <form method="post" action="stored_vuln.php">
    <label for="name">Name</label>
    <input id="name" name="name" />
    <label for="message">Message</label>
    <textarea id="message" name="message"></textarea>
    <button type="submit">Post</button>
  </form>

  <?php
  // Simple JSON file-backed storage (for classroom demo only)
  $datadir = __DIR__ . '/../data';
  @mkdir($datadir);
  $path = $datadir . '/messages.json';
  if (!file_exists($path)) {
    file_put_contents($path, json_encode([]));
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $message = $_POST['message'] ?? '';
    $all = json_decode(file_get_contents($path), true);
    $all[] = ['name' => $name, 'message' => $message, 'time' => time()];
    file_put_contents($path, json_encode($all));
    echo "<p style='color:green;'>Posted (vulnerable)</p>";
  }

  // Display messages WITHOUT escaping (intentionally vulnerable)
  $msgs = json_decode(file_get_contents($path), true);
  echo "<h2>Messages</h2>";
  if ($msgs) {
    foreach ($msgs as $m) {
      echo "<div class=\"message\">";
      echo "<strong>" . $m['name'] . "</strong>: ";
      echo "<div>" . $m['message'] . "</div>"; // vulnerable echo
      echo "</div>";
    }
  } else {
    echo "<p>No messages yet.</p>";
  }
  ?>
</div>
