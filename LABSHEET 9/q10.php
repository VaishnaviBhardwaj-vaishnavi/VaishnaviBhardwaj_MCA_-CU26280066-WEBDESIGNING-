<?php
require_once "db.php";

if(isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    $stmt = $conn->prepare(
        "DELETE FROM products WHERE id=?"
    );

    $stmt->execute([$id]);

    echo "Product deleted successfully!";
}
?>

<a href="delete_product.php?id=1"
onclick="return confirm('Are you sure you want to delete?')">
Delete Product
</a>