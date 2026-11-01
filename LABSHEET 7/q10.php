<?php
require_once "config/db.php";

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');

$sql = "SELECT * FROM books WHERE stock > 0";
$params = [];
$types = "";

if ($search !== "") {

    $sql .= " AND (title LIKE ? OR author LIKE ? OR category LIKE ?)";

    $value = "%$search%";

    $params[] = $value;
    $params[] = $value;
    $params[] = $value;

    $types .= "sss";
}

if ($category !== "") {

    $sql .= " AND category = ?";

    $params[] = $category;
    $types .= "s";
}

$stmt = $conn->prepare($sql);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();
?>

<h1>Search Books</h1>

<form method="GET">

    <input type="text" name="search"
           placeholder="Search title or author"
           value="<?php echo htmlspecialchars($search); ?>">

    <select name="category">

        <option value="">All Categories</option>
        <option value="Fiction">Fiction</option>
        <option value="Technology">Technology</option>
        <option value="Education">Education</option>
        <option value="Finance">Finance</option>

    </select>

    <button type="submit">Search</button>

</form>

<div class="book-grid">

<?php while ($book = $result->fetch_assoc()) { ?>

    <div class="book-card">

        <h3><?php echo htmlspecialchars($book['title']); ?></h3>

        <p><?php echo htmlspecialchars($book['author']); ?></p>

        <p>₹<?php echo $book['price']; ?></p>

        <a href="book-details.php?id=<?php echo $book['id']; ?>">
            View Book
        </a>

    </div>

<?php } ?>

</div>