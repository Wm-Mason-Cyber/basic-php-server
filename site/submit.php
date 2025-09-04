<?php include 'nav.php'; ?>
<div class="container">
  <h1>Contact Form Submission</h1>
  <?php
  // Intentionally vulnerable to reflected XSS
  if (isset($_GET['name']) && isset($_GET['message'])) {
    echo "<p><strong>Name:</strong> " . $_GET['name'] . "</p>";
    echo "<p><strong>Message:</strong> " . $_GET['message'] . "</p>";
    echo "<p style='color:red;'>This page is intentionally vulnerable to XSS. Try submitting &lt;script&gt;alert('XSS')&lt;/script&gt; as your name or message.</p>";
  } else {
    echo "<p>No data submitted.</p>";
  }
  ?>
</div>
