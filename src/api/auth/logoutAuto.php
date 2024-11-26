<?php

$cleared = false;

if (session_status() === PHP_SESSION_ACTIVE) {
  if (isset($_SESSION['auth_timestamp'])) {
    if (time() - $_SESSION['auth_timestamp'] > 300) {
      $_SESSION['auth_timestamp'] = 0;
      $_SESSION['auth'] = false;
      session_unset();
      session_destroy();
      session_start();
      $cleared = true;
    }
  }
}
