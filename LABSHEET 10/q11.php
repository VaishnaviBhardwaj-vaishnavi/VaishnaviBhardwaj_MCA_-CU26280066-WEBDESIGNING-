<?php

$isHttps = !empty($_SERVER['HTTPS']) &&
           $_SERVER['HTTPS'] !== 'off';

session_name("MYSESSION");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

// After successful login:
session_regenerate_id(true);

$_SESSION['user'] = "Admin";

echo "Secure session started";

?>