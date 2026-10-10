<?php
require 'connect.php';

$id = 1;
$email = "newemail@example.com";

$stmt = $pdo->prepare(
    "UPDATE students SET email = ? WHERE id = ?"
);

$stmt->execute([$email, $id]);

echo "Student Email Updated Successfully!";
?>