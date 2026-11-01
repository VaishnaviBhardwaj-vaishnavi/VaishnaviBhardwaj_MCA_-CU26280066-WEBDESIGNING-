<?php
session_start();
require_once "db.php";

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email=?"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify(
        $password,
        $user['password']
    )) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        if(isset($_POST['remember'])) {

            setcookie('username', $user['name'], [
                'expires' => time() + 86400*30,
                'path' => '/',
                'httponly' => true,
                'secure' => !empty($_SERVER['HTTPS']),
                'samesite' => 'Lax'
            ]);
        }

        echo "Login successful!";

    } else {
        echo "Invalid login!";
    }
}
?>

<form method="post">

    Email:
    <input type="email" name="email" required>

    Password:
    <input type="password" name="password" required>

    <label>
        <input type="checkbox" name="remember">
        Remember Me
    </label>

    <button name="login">Login</button>

</form>

<?php
if(isset($_COOKIE['username'])) {
    echo "Welcome back, " .
    htmlspecialchars($_COOKIE['username']);
}
?>