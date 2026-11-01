<?php

require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['user_id']) ||
    !isset($_SESSION['last_order_id'])) {

    exit("No recent order found.");
}

$orderId = (int)$_SESSION['last_order_id'];

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE id = ? AND user_id = ?"
);

$stmt->bind_param(
    "ii",
    $orderId,
    $_SESSION['user_id']
);

$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    exit("Order not found.");
}

?>

<h1>Order Placed Successfully!</h1>

<h2>Order Number: #<?php echo $order['id']; ?></h2>

<p>Total Amount: ₹<?php echo $order['total_amount']; ?></p>

<p>Status: <?php echo htmlspecialchars($order['status']); ?></p>

<p>Shipping Address:
    <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?>
</p>

<a href="invoice.php?id=<?php echo $order['id']; ?>">
    Download/View Invoice
</a>

<a href="books.php">Continue Shopping</a>



<?php

require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['user_id'])) {
    exit("Please login.");
}

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE id = ? AND user_id = ?"
);

$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    exit("Invoice not found.");
}

$stmt = $conn->prepare(
    "SELECT books.title, order_items.quantity,
            order_items.price
     FROM order_items
     JOIN books ON order_items.book_id = books.id
     WHERE order_items.order_id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$items = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Invoice</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="invoice">

    <h1>BOOKSTORE INVOICE</h1>

    <h3>Invoice Number: #<?php echo $order['id']; ?></h3>

    <p>Date: <?php echo $order['created_at']; ?></p>

    <p>Shipping Address:
        <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?>
    </p>

    <table border="1" cellpadding="10">

        <tr>
            <th>Book</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>

        <?php while ($item = $items->fetch_assoc()) { ?>

        <tr>
            <td><?php echo htmlspecialchars($item['title']); ?></td>

            <td><?php echo $item['quantity']; ?></td>

            <td>₹<?php echo $item['price']; ?></td>

            <td>₹<?php echo $item['price'] * $item['quantity']; ?></td>
        </tr>

        <?php } ?>

    </table>

    <h2>
        Grand Total: ₹<?php echo $order['total_amount']; ?>
    </h2>

    <button onclick="window.print()">Print Invoice</button>

</div>

</body>
</html>