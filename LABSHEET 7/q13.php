<?php
require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$message = "";

if (isset($_POST['add'])) {

    $id = (int)$_POST['book_id'];
    $quantity = max(1, (int)$_POST['quantity']);

    $stmt = $conn->prepare(
        "SELECT stock FROM books WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $book = $stmt->get_result()->fetch_assoc();

    if (!$book) {

        $message = "Book not found.";

    } else {

        $currentQuantity = $_SESSION['cart'][$id] ?? 0;

        if ($currentQuantity + $quantity <= $book['stock']) {

            $_SESSION['cart'][$id] = $currentQuantity + $quantity;

            $message = "Book added to cart successfully!";

        } else {

            $message = "Sorry! Available stock is only "
                     . $book['stock'] . ".";
        }
    }
}
?>

<h1>Stock Check</h1>

<form method="POST">

    <input type="number" name="book_id"
           placeholder="Book ID" min="1" required>

    <input type="number" name="quantity"
           placeholder="Quantity" min="1" required>

    <button type="submit" name="add">
        Add to Cart
    </button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>