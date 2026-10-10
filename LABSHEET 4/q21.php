<?php
$password = "MySecurePass123";

$hash = password_hash($password, PASSWORD_DEFAULT);

if (password_verify($password, $hash)) {
    echo "Password Verified Successfully!";
} else {
    echo "Invalid Password!";
}
?>