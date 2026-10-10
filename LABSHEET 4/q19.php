<?php
require 'connect.php';

try {
    $pdo->beginTransaction();

    $pdo->exec("UPDATE students SET email = 'test@example.com' WHERE id = 1");
    $pdo->exec("INSERT INTO students (name, email, enrollment_date)
                VALUES ('Aman', 'aman@example.com', '2026-10-10')");

    $pdo->commit();
    echo "Transaction Committed Successfully!";
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "Transaction Failed and Rolled Back!";
}
?>