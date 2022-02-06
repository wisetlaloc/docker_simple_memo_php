<?php
  session_start();
  if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
    echo '<div class="alert alert-danger" role="alert">';
    foreach ($_SESSION['errors'] as $error) {
      echo "<div>{$error}</div>";
    }
    echo '</div>';
    unset($_SESSION['errors']);
  }
?>