<?php
require_once "db.php";

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product) {
    die("Product not found");
}

if(isset($_POST['update'])) {

    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $sql = "UPDATE products
            SET name=?, category=?, price=?
            WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $name, $category, $price, $id
    ]);

    echo "Product updated successfully!";
}
?>

<form method="post">

    Name:
    <input type="text" name="name"
    value="<?= htmlspecialchars($product['name']) ?>"><br>

    Category:
    <input type="text" name="category"
    value="<?= htmlspecialchars($product['category']) ?>"><br>

    Price:
    <input type="number" step="0.01" name="price"
    value="<?= htmlspecialchars($product['price']) ?>"><br>

    <button name="update">Update Product</button>

</form>