<?php
require_once "config/db.php";

$limit = 6;

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

if (!$page || $page < 1) {
    $page = 1;
}

$countResult = $conn->query(
    "SELECT COUNT(*) AS total FROM books WHERE stock > 0"
);

$totalBooks = $countResult->fetch_assoc()['total'];

$totalPages = max(1, ceil($totalBooks / $limit));

$page = min($page, $totalPages);

$offset = ($page - 1) * $limit;

$stmt = $conn->prepare(
    "SELECT * FROM books
     WHERE stock > 0
     LIMIT ? OFFSET ?"
);

$stmt->bind_param("ii", $limit, $offset);

$stmt->execute();

$result = $stmt->get_result();
?>

<h1>Book Collection</h1>

<div class="book-grid">

<?php while ($book = $result->fetch_assoc()) { ?>

    <div class="book-card">

        <h3><?php echo htmlspecialchars($book['title']); ?></h3>

        <p>₹<?php echo $book['price']; ?></p>

    </div>

<?php } ?>

</div>

<div class="pagination">

<?php for ($i = 1; $i <= $totalPages; $i++) { ?>

    <a href="?page=<?php echo $i; ?>"
       class="<?php echo $page == $i ? 'active' : ''; ?>">

        <?php echo $i; ?>

    </a>

<?php } ?>

</div>