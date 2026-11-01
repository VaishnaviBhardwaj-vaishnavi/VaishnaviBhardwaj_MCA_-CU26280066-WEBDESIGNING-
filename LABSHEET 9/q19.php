<?php
session_start();
require_once "db.php";

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if(empty($_SESSION['cart'])) {
    die("Shopping cart is empty!");
}

try {

    // Start transaction
    $conn->beginTransaction();

    foreach($_SESSION['cart'] as $id => $qty) {

        $stmt = $conn->prepare(
            "SELECT price FROM products
             WHERE id=? FOR UPDATE"
        );

        $stmt->execute([$id]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$product) {
            throw new Exception("Product not found.");
        }

        $price = $product['price'];
        $total = $price * $qty;

        $sql = "INSERT INTO orders
                (user_id, product_id, quantity, total_price)
                VALUES (?, ?, ?, ?)";

        $insert = $conn->prepare($sql);

        $insert->execute([
            $_SESSION['user_id'],
            $id,
            $qty,
            $total
        ]);
    }

    // Save transaction
    $conn->commit();

    $_SESSION['cart'] = [];

    echo "Order placed successfully!";

}
catch(Exception $e) {

    // Undo transaction if error occurs
    if($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo "Checkout failed: " .
    htmlspecialchars($e->getMessage());
}
?>