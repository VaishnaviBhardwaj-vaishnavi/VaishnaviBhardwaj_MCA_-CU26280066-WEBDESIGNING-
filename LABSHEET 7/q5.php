<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<?php
require_once "config/db.php";
require_once "includes/auth.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || strlen($password) < 8) {

        $message = "Enter valid details. Password must have 8 characters.";

    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users(name,email,password) VALUES(?,?,?)"
        );

        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Email already registered.";
        }
    }
}
?>

<h2>User Registration</h2>

<form method="POST" id="registerForm">

    <input type="text" name="name" placeholder="Full Name" required>

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password"
           placeholder="Password (minimum 8 characters)" required>

    <button type="submit">Register</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>


<?php
require_once "config/db.php";
require_once "includes/auth.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php");
        exit();

    } else {
        $message = "Invalid email or password.";
    }
}
?>

<h2>User Login</h2>

<form method="POST" id="loginForm">

    <input type="email" name="email" placeholder="Email" required>

    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login</button>

</form>

<p><?php echo htmlspecialchars($message); ?></p>


<?php

require_once "includes/auth.php";

$_SESSION = [];

session_destroy();

header("Location: login.php");
exit();

?>