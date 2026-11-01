<?php
require_once "db.php";

$stmt = $conn->query("SELECT * FROM products");
?>

<h2>Product List</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Price</th>
</tr>

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

<tr>
    <td><?= (int)$row['id'] ?></td>

    <td><?= htmlspecialchars($row['name']) ?></td>

    <td><?= htmlspecialchars($row['category']) ?></td>

    <td><?= htmlspecialchars($row['price']) ?></td>
</tr>

<?php } ?>

</table>