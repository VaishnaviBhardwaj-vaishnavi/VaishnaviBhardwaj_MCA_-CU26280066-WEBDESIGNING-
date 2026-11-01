<?php
require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT * FROM orders
     WHERE user_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();
?>

<h1>My Order History</h1>

<table border="1" cellpadding="10">

<tr>
    <th>Order ID</th>
    <th>Order Date</th>
    <th>Total Amount</th>
    <th>Status</th>
    <th>Invoice</th>
</tr>

<?php while ($order = $result->fetch_assoc()) { ?>

<tr>

    <td><?php echo $order['id']; ?></td>

    <td><?php echo $order['created_at']; ?></td>

    <td>₹<?php echo $order['total_amount']; ?></td>

    <td><?php echo htmlspecialchars($order['status']); ?></td>

    <td>
        <a href="invoice.php?id=<?php echo $order['id']; ?>">
            View Invoice
        </a>
    </td>

</tr>

<?php } ?>

</table>