<?php
require 'connect.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare(
    "SELECT password_hash FROM users WHERE username = ?"
);
$stmt->execute([$username]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password_hash'])) {
    echo "Login Successful!";
} else {
    echo "Invalid Username or Password!";
}
?>