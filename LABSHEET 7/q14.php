<?php

require_once "config/db.php";

// Receive and sanitize input
$title = trim($_POST['title'] ?? '');

// Validate input
if ($title === "") {
    exit("Book title is required.");
}

// Use prepared statement
$stmt = $conn->prepare(
    "SELECT * FROM books WHERE title LIKE ?"
);

$search = "%" . $title . "%";

$stmt->bind_param("s", $search);

$stmt->execute();

$result = $stmt->get_result();

// Display safely
while ($book = $result->fetch_assoc()) {

    echo htmlspecialchars(
        $book['title'],
        ENT_QUOTES,
        'UTF-8'
    );

    echo "<br>";
}

?>