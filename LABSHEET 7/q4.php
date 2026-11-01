<?php
require_once "config/db.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    exit("Invalid book ID");
}

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$book = $stmt->get_result()->fetch_assoc();

if (!$book) {
    exit("Book not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="book-detail">

    <img src="images/<?php echo htmlspecialchars($book['image']); ?>"
         alt="Book cover">

    <h2><?php echo htmlspecialchars($book['title']); ?></h2>

    <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>

    <p>Category: <?php echo htmlspecialchars($book['category']); ?></p>

    <p>Price: ₹<?php echo number_format($book['price'], 2); ?></p>

    <p>Available Stock: <?php echo $book['stock']; ?></p>

    <a href="cart.php?action=add&id=<?php echo $book['id']; ?>">
        Add to Cart
    </a>

</div>

</body>
</html>
   