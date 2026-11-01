<?php
require_once "db.php";

$limit = 5;

$page = isset($_GET['page'])
        ? max(1, (int)$_GET['page']) : 1;

$offset = ($page - 1) * $limit;

$total = $conn->query(
    "SELECT COUNT(*) FROM products"
)->fetchColumn();

$totalPages = ceil($total / $limit);

$stmt = $conn->prepare(
    "SELECT * FROM products LIMIT ? OFFSET ?"
);

$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);

$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo htmlspecialchars($row['name']) . "<br>";
}

echo "<br>";

if($page > 1) {
    echo "<a href='?page=".($page-1)."'>Previous</a> ";
}

for($i=1; $i<=$totalPages; $i++) {

    echo "<a href='?page=$i'>$i</a> ";
}

if($page < $totalPages) {
    echo "<a href='?page=".($page+1)."'>Next</a>";
}
?>