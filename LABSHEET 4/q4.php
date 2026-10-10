<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=college_db;charset=utf8mb4",
        "root",
        ""
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database Connected Successfully!";
} catch (PDOException $e) {
    die("Connection Failed!");
}
?>