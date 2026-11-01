<?php
require_once "db.php";

$email = $_GET['email'] ?? '';

/* Vulnerable query - educational example only.
   Never execute this with untrusted input.

$sql = "SELECT * FROM users
        WHERE email='$email'";
*/

/* Secure query using prepared statement */

$stmt = $conn->prepare(
    "SELECT * FROM users WHERE email=?"
);

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
    echo "User found!";
} else {
    echo "User not found!";
}
?>

<form method="get">

    Enter Email:
    <input type="email" name="email">

    <button>Search</button>

</form>