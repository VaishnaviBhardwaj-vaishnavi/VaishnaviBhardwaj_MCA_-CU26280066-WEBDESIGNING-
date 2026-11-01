<?php
require_once "../config/db.php";
require_once "../includes/auth.php";

if (!isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Access denied");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = (int)$_POST['id'];
    $status = $_POST['status'];

    $allowed = ['Pending', 'Shipped', 'Delivered'];

    if (in_array($status, $allowed, true)) {

        $stmt = $conn->prepare(
            "UPDATE orders SET status=? WHERE id=?"
        );

        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        $message = "Order status updated.";
    }
}

$result = $conn->query(
    "SELECT orders.*, users.name, users.email
     FROM orders
     JOIN users ON orders.user_id = users.id
     ORDER BY orders.created_at DESC"
);
?>

<h1>Customer Orders</h1>

<p><?php echo htmlspecialchars($message); ?></p>

<table border="1" cellpadding="10">

<tr>
    <th>Order ID</th>
    <th>Customer</th>
    <th>Email</th>
    <th>Total</th>
    <th>Status</th>
    <th>Update</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo htmlspecialchars($row['name']); ?></td>

    <td><?php echo htmlspecialchars($row['email']); ?></td>

    <td>₹<?php echo $row['total_amount']; ?></td>

    <td><?php echo htmlspecialchars($row['status']); ?></td>

    <td>
        <form method="POST">

            <input type="hidden" name="id"
                   value="<?php echo $row['id']; ?>">

            <select name="status">
                <option>Pending</option>
                <option>Shipped</option>
                <option>Delivered</option>
            </select>

            <button type="submit">Update</button>

        </form>
    </td>

</tr>

<?php } ?>

</table>