<?php
require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_GET['action'] ?? '';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($action === "add" && $id) {

    $stmt = $conn->prepare(
        "SELECT stock FROM books WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if ($book && $book['stock'] > ($_SESSION['cart'][$id] ?? 0)) {
        $_SESSION['cart'][$id] =
            ($_SESSION['cart'][$id] ?? 0) + 1;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST['update'])) {

        foreach ($_POST['quantity'] as $bookId => $quantity) {

            $bookId = (int)$bookId;
            $quantity = max(0, (int)$quantity);

            $stmt = $conn->prepare(
                "SELECT stock FROM books WHERE id = ?"
            );

            $stmt->bind_param("i", $bookId);
            $stmt->execute();

            $book = $stmt->get_result()->fetch_assoc();

            if (!$book || $quantity === 0) {
                unset($_SESSION['cart'][$bookId]);
            } else {
                $_SESSION['cart'][$bookId] =
                    min($quantity, (int)$book['stock']);
            }
        }
    }

    if (isset($_POST['remove'])) {
        $removeId = (int)$_POST['remove'];
        unset($_SESSION['cart'][$removeId]);
    }
}
?>

<h1>Shopping Cart</h1>

<form method="POST">

<?php

$total = 0;

foreach ($_SESSION['cart'] as $bookId => $quantity) {

    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if (!$book) continue;

    $quantity = min($quantity, $book['stock']);
    $subtotal = $book['price'] * $quantity;
    $total += $subtotal;

?>

    <div>
        <h3><?php echo htmlspecialchars($book['title']); ?></h3>

        <p>Price: ₹<?php echo $book['price']; ?></p>

        <input type="number"
               name="quantity[<?php echo $bookId; ?>]"
               value="<?php echo $quantity; ?>"
               min="0"
               max="<?php echo $book['stock']; ?>">

        <p>Subtotal: ₹<?php echo $subtotal; ?></p>

        <button name="remove" value="<?php echo $bookId; ?>">
            Remove
        </button>
    </div>

<?php } ?>

<button type="submit" name="update">Update Cart</button>

</form>

<h2>Total: ₹<?php echo number_format($total, 2); ?></h2>

<a href="checkout.php">Proceed to Checkout</a>