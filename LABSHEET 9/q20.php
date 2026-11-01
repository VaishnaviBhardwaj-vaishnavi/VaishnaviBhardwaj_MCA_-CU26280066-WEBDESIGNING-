<?php
require_once "db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Live Product Search</title>
</head>

<body>

<h2>Live Product Search</h2>

<input type="text"
       id="search"
       placeholder="Search products...">

<div id="result"></div>

<script>

document.getElementById("search")
.addEventListener("keyup", function() {

    let keyword = this.value;

    fetch("search.php?search=" +
          encodeURIComponent(keyword))

    .then(response => response.json())

    .then(data => {

        let output = "";

        data.forEach(product => {

            output += "<p>" +
                product.name +
                " - ₹" +
                product.price +
                "</p>";

        });

        document.getElementById("result")
        .innerHTML = output;

    });

});

</script>

</body>
</html>




<?php
require_once "db.php";

header("Content-Type: application/json");

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare(
    "SELECT name, price FROM products
     WHERE name LIKE ?
     LIMIT 10"
);

$stmt->execute(["%$search%"]);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($products);
?>