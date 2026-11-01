<?php
session_start();
require_once "db.php";

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product
if(isset($_GET['add'])) {

    $id = (int)$_GET['add'];

    $stmt = $conn->prepare(
        "SELECT id FROM products WHERE id=?"
    );
    $stmt->execute([$id]);

    if($stmt->fetch()) {
        $_SESSION['cart'][$id] =
        ($_SESSION['cart'][$id] ?? 0) + 1;
    }
}

// Update quantity
if(isset($_POST['update'])) {

    $id = (int)$_POST['id'];
    $qty = (int)$_POST['quantity'];

    if(isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = max(1, min(99, $qty));
    }
}

// Remove product
if(isset($_GET['remove'])) {

    $id = (int)$_GET['remove'];

    unset($_SESSION['cart'][$id]);
}

$total = 0;

foreach($_SESSION['cart'] as $id => $qty) {

    $stmt = $conn->prepare(
        "SELECT * FROM products WHERE id=?"
    );

    $stmt->execute([$id]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if($product) {

        $subtotal = $product['price'] * $qty;
        $total += $subtotal;

        echo htmlspecialchars($product['name']);
        echo " - ₹" . number_format($subtotal, 2);

        echo "<br>";

        echo "<a href='?remove=$id'>Remove</a>";
        echo "<hr>";
    }
}

echo "<h3>Total: ₹" .
number_format($total, 2) . "</h3>";
?>

<a href="checkout.php">Checkout</a>