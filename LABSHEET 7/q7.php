<?php
require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    exit("Your cart is empty.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $address = trim($_POST['address']);

    if ($address === "") {
        $message = "Enter your shipping address.";
    } else {

        $conn->begin_transaction();

        try {

            $total = 0;
            $items = [];

            foreach ($_SESSION['cart'] as $id => $qty) {

                $stmt = $conn->prepare(
                    "SELECT price, stock FROM books WHERE id = ? FOR UPDATE"
                );

                $stmt->bind_param("i", $id);
                $stmt->execute();

                $book = $stmt->get_result()->fetch_assoc();

                if (!$book || $qty < 1 || $qty > $book['stock']) {
                    throw new Exception("Insufficient stock.");
                }

                $total += $book['price'] * $qty;

                $items[] = [
                    'id' => $id,
                    'qty' => $qty,
                    'price' => $book['price']
                ];
            }

            $userId = $_SESSION['user_id'];

            $stmt = $conn->prepare(
                "INSERT INTO orders
                (user_id,total_amount,shipping_address)
                VALUES(?,?,?)"
            );

            $stmt->bind_param("ids", $userId, $total, $address);
            $stmt->execute();

            $orderId = $conn->insert_id;

            foreach ($items as $item) {

                $stmt = $conn->prepare(
                    "INSERT INTO order_items
                    (order_id,book_id,quantity,price)
                    VALUES(?,?,?,?)"
                );

                $stmt->bind_param(
                    "iiid",
                    $orderId,
                    $item['id'],
                    $item['qty'],
                    $item['price']
                );

                $stmt->execute();

                $stmt = $conn->prepare(
                    "UPDATE books SET stock = stock - ?
                     WHERE id = ? AND stock >= ?"
                );

                $stmt->bind_param(
                    "iii",
                    $item['qty'],
                    $item['id'],
                    $item['qty']
                );

                $stmt->execute();

                if ($stmt->affected_rows !== 1) {
                    throw new Exception("Stock update failed.");
                }
            }

            $conn->commit();

            $_SESSION['cart'] = [];

            $_SESSION['last_order_id'] = $orderId;

            header("Location: order-success.php");
            exit();

        } catch (Throwable $e) {

            $conn->rollback();
            $message = $e->getMessage();
        }
    }
}
?>

<h1>Checkout</h1>

<form method="POST" id="checkoutForm">

    <textarea name="address"
              placeholder="Enter shipping address"
              required></textarea>

    <button type="submit">Place Order</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>