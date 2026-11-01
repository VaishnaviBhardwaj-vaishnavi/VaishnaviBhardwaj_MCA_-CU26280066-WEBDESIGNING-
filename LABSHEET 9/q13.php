<?php
require_once "db.php";

$column = $_GET['column'] ?? 'id';
$order = $_GET['order'] ?? 'ASC';

$allowed = ['id', 'name', 'category', 'price'];

if(!in_array($column, $allowed, true)) {
    $column = 'id';
}

$order = strtoupper($order);

if(!in_array($order, ['ASC', 'DESC'], true)) {
    $order = 'ASC';
}

$sql = "SELECT * FROM products
        ORDER BY $column $order";

$stmt = $conn->query($sql);
?>

<table border="1" cellpadding="10">

<tr>
    <th>
        <a href="?column=name&order=ASC">Name ↑</a>
        |
        <a href="?column=name&order=DESC">Name ↓</a>
    </th>

    <th>
        <a href="?column=price&order=ASC">Price ↑</a>
        |
        <a href="?column=price&order=DESC">Price ↓</a>
    </th>
</tr>

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

<tr>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['price']) ?></td>
</tr>

<?php } ?>

</table>