<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

if (isset($_SESSION['auth']) && isset($_SESSION['auth_timestamp'])) {
  if ($_SESSION['auth']) {
    $_SESSION['auth_timestamp'] = 0;
    $_SESSION['auth'] = false;
    session_unset();
    session_destroy();
    echo "{ \"error\" : null, \"value\" : null }";
    http_response_code(200);
    die();
  }
}
echo "{ \"error\" : \"You're already logged out!\", \"value\" : null }";
http_response_code(400);
die();
