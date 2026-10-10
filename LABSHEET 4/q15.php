<?php
session_start();

$_SESSION['username'] = 'Rahul';

echo "Welcome " . htmlspecialchars($_SESSION['username']);
?>