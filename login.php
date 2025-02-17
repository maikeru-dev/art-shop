<?php
// src/api/auth/login.php

require_once 'src/utilities/Util.php';

if (!session_start()) {
  error_log("Session failed to start!");
}

require_once 'src/api/auth/logoutAuto.php'; // I can't remember why I put this here.

if ($cleared) {
  http_response_code(200);
  die();
}

$PASS_HASH = password_hash("WeKnowTheGame24", PASSWORD_DEFAULT);

// Expect POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(404);
  die();
}

if (!isset($_SERVER["HTTP_AUTHORIZATION"])) {
  http_response_code(400);
  die();
}

$password = base64_decode(explode(" ", $_SERVER["HTTP_AUTHORIZATION"])[1]);

if (password_verify($password, $PASS_HASH)) {
  $_SESSION['auth'] = true;
  $_SESSION['auth_timestamp'] = time();
  echo "{ \"error\" : null, \"value\" : null }";
  http_response_code(200);
} else {
  echo "{ \"error\": \"Bad passowrd.\", \"value\" : null }";
  http_response_code(401);
}
