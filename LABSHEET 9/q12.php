<?php
require_once "db.php";

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';

$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if($search != '') {
    $sql .= " AND name LIKE ?";
    $params[] = "%$search%";
}

if($category != '') {
    $sql .= " AND category LIKE ?";
    $params[] = "%$category%";
}

if($min !== '' && $max !== ''
   && is_numeric($min) && is_numeric($max)
   && $min <= $max) {

    $sql .= " AND price BETWEEN ? AND ?";
    $params[] = $min;
    $params[] = $max;
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);
?>

<form method="get">

    Search:
    <input type="text" name="search">

    Category:
    <input type="text" name="category">

    Minimum Price:
    <input type="number" name="min">

    Maximum Price:
    <input type="number" name="max">

    <button>Search</button>

</form>

<h2>Search Results</h2>

<?php
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo htmlspecialchars($row['name']);
    echo " - ₹" . htmlspecialchars($row['price']);
    echo "<br>";
}
?>