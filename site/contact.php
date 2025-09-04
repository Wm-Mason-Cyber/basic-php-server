<?php include 'nav.php'; ?>
<div class="container">
  <h1>Contact Us</h1>
  <form method="get" action="submit.php">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="message">Message:</label>
    <textarea id="message" name="message" required></textarea>
    <button type="submit">Send</button>
  </form>
</div>
