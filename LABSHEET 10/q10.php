<?php

session_start();

if(empty($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );
}

function csrf_field() {

    return '<input type="hidden" name="csrf_token" value="' .
    htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') .
    '">';
}

function verify_csrf() {

    if(
        !isset($_POST['csrf_token']) ||
        !hash_equals(
            $_SESSION['csrf_token'],
            $_POST['csrf_token']
        )
    ) {

        die("Invalid CSRF Token");
    }
}
?>