<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h1>Welcome to Dashboard</h1>

<h2>
Welcome, <?php
echo htmlspecialchars($_SESSION['name']);
?>
</h2>

<a href="logout.php">Logout</a>