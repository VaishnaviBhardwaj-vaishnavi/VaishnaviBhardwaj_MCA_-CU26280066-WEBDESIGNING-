<?php
require_once "db.php";

if(isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if($name == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)
       || strlen($password) < 8) {
        die("Please enter valid details. Password must be 8 characters.");
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name,email,password)
            VALUES(?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$name,$email,$hash]);

    echo "Registration successful!";
}
?>

<form method="post">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button name="register">Register</button>
</form>