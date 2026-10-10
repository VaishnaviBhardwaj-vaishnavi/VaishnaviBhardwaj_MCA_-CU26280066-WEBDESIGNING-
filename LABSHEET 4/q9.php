<?php
require 'connect.php';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([(int) $_GET['id']]);

    echo "Student Deleted Successfully!";
} else {
    echo "Invalid Student ID!";
}
?>