<?php

require_once "../config/db.php";
require_once "../includes/auth.php";

if (!isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin') {

    http_response_code(403);
    exit("Access denied");
}

// Total Orders
$totalOrders = $conn->query(
    "SELECT COUNT(*) AS total FROM orders"
)->fetch_assoc()['total'];

// Total Revenue
$totalRevenue = $conn->query(
    "SELECT COALESCE(SUM(total_amount),0) AS revenue
     FROM orders
     WHERE status IN ('Shipped','Delivered')"
)->fetch_assoc()['revenue'];

// Total Customers
$totalCustomers = $conn->query(
    "SELECT COUNT(*) AS total FROM users
     WHERE role = 'customer'"
)->fetch_assoc()['total'];

// Total Books Sold
$totalBooks = $conn->query(
    "SELECT COALESCE(SUM(quantity),0) AS total
     FROM order_items
     JOIN orders ON order_items.order_id = orders.id
     WHERE orders.status IN ('Shipped','Delivered')"
)->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Reports</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container">

    <h1>Bookstore Sales Report</h1>

    <div class="dashboard">

        <div class="card">
            <h2>Total Orders</h2>
            <h3><?php echo $totalOrders; ?></h3>
        </div>

        <div class="card">
            <h2>Total Revenue</h2>
            <h3>₹<?php echo number_format($totalRevenue, 2); ?></h3>
        </div>

        <div class="card">
            <h2>Total Customers</h2>
            <h3><?php echo $totalCustomers; ?></h3>
        </div>

        <div class="card">
            <h2>Books Sold</h2>
            <h3><?php echo $totalBooks; ?></h3>
        </div>

    </div>

</div>

</body>
</html>