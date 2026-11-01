<?php

require_once "config/db.php";
require_once "includes/auth.php";

if (!isset($_SESSION['user_id'])) {
    exit("Please login first.");
}

$userId = $_SESSION['user_id'];

if (isset($_GET['add'])) {

    $bookId = (int)$_GET['add'];

    $stmt = $conn->prepare(
        "INSERT IGNORE INTO wishlist(user_id,book_id)
         VALUES(?,?)"
    );

    $stmt->bind_param("ii", $userId, $bookId);
    $stmt->execute();
}

if (isset($_GET['remove'])) {

    $bookId = (int)$_GET['remove'];

    $stmt = $conn->prepare(
        "DELETE FROM wishlist
         WHERE user_id = ? AND book_id = ?"
    );

    $stmt->bind_param("ii", $userId, $bookId);
    $stmt->execute();
}

$stmt = $conn->prepare(
    "SELECT books.*
     FROM wishlist
     JOIN books ON wishlist.book_id = books.id
     WHERE wishlist.user_id = ?"
);

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();

?>

<h1>My Wishlist</h1>

<?php while ($book = $result->fetch_assoc()) { ?>

    <div class="book-card">

        <h3><?php echo htmlspecialchars($book['title']); ?></h3>

        <p>₹<?php echo $book['price']; ?></p>

        <a href="wishlist.php?remove=<?php echo $book['id']; ?>">
            Remove from Wishlist
        </a>

    </div>

<?php } ?>



<a href="wishlist.php?add=<?php echo $book['id']; ?>">
    Add to Wishlist
</a>

