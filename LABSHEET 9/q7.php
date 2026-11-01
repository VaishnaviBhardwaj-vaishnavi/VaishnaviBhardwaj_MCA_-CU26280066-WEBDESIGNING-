<?php
require_once "db.php";

if(isset($_POST['submit'])) {

    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products
            (name, category, price)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $name,
        $category,
        $price
    ]);

    echo "Product inserted successfully!";
}
?>

<form method="post">
    Product Name:
    <input type="text" name="name" required><br>

    Category:
    <input type="text" name="category" required><br>

    Price:
    <input type="number" name="price" step="0.01" required><br>

    <button name="submit">Add Product</button>
</form>