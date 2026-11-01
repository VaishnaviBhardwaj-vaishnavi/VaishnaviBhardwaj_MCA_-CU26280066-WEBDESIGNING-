<?php
require_once "../config/db.php";
require_once "../includes/auth.php";

if (!isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin') {

    http_response_code(403);
    exit("Access denied");
}

$books = $conn->query("SELECT COUNT(*) AS total FROM books")
              ->fetch_assoc();

$orders = $conn->query("SELECT COUNT(*) AS total FROM orders")
               ->fetch_assoc();

$users = $conn->query("SELECT COUNT(*) AS total FROM users")
              ->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Admin Dashboard</h1>

<div class="dashboard">

    <div class="card">
        <h2>Total Books</h2>
        <h3><?php echo $books['total']; ?></h3>
    </div>

    <div class="card">
        <h2>Total Orders</h2>
        <h3><?php echo $orders['total']; ?></h3>
    </div>

    <div class="card">
        <h2>Total Users</h2>
        <h3><?php echo $users['total']; ?></h3>
    </div>

</div>

<a href="add-book.php">Add New Book</a><br>
<a href="manage-books.php">Manage Inventory</a><br>
<a href="orders.php">Manage Orders</a><br>
<a href="reports.php">Sales Reports</a>

</body>
</html>

<?php
require_once "../config/db.php";
require_once "../includes/auth.php";

if (!isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Access denied");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = trim($_POST['image']);

    if ($title === "" || $author === "" ||
        $price <= 0 || $stock < 0) {

        $message = "Please enter valid book details.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO books
            (title,author,category,price,stock,image)
            VALUES(?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "sssdis",
            $title, $author, $category,
            $price, $stock, $image
        );

        $message = $stmt->execute()
            ? "Book added successfully!"
            : "Unable to add book.";
    }
}
?>

<h1>Add New Book</h1>

<form method="POST">

    <input type="text" name="title" placeholder="Book Title" required>

    <input type="text" name="author" placeholder="Author" required>

    <input type="text" name="category" placeholder="Category">

    <input type="number" name="price" placeholder="Price"
           min="0.01" step="0.01" required>

    <input type="number" name="stock" placeholder="Stock"
           min="0" required>

    <input type="text" name="image" placeholder="Image filename">

    <button type="submit">Add Book</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>


<?php
require_once "../config/db.php";
require_once "../includes/auth.php";

if (!isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Access denied");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $category = trim($_POST['category']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = trim($_POST['image']);

    if ($title === "" || $author === "" ||
        $price <= 0 || $stock < 0) {

        $message = "Please enter valid book details.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO books
            (title,author,category,price,stock,image)
            VALUES(?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "sssdis",
            $title, $author, $category,
            $price, $stock, $image
        );

        $message = $stmt->execute()
            ? "Book added successfully!"
            : "Unable to add book.";
    }
}
?>

<h1>Add New Book</h1>

<form method="POST">

    <input type="text" name="title" placeholder="Book Title" required>

    <input type="text" name="author" placeholder="Author" required>

    <input type="text" name="category" placeholder="Category">

    <input type="number" name="price" placeholder="Price"
           min="0.01" step="0.01" required>

    <input type="number" name="stock" placeholder="Stock"
           min="0" required>

    <input type="text" name="image" placeholder="Image filename">

    <button type="submit">Add Book</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>