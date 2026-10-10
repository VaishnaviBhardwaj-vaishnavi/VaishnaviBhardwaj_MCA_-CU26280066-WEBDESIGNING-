<?php
require 'connect.php';

$sql = "INSERT INTO students (name, email, enrollment_date)
        VALUES (?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "Rahul Sharma",
    "rahul@example.com",
    "2026-10-10"
]);

echo "Student Inserted Successfully!";
?>