<?php

session_start();

$correctPassword = "admin123";

if(!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if(
    isset($_SESSION['locked_until']) &&
    time() < $_SESSION['locked_until']
) {
    die("Account locked. Try again after 15 minutes.");
}

if(isset($_POST['login'])) {

    $password = $_POST['password'] ?? '';

    if($password === $correctPassword) {

        $_SESSION['attempts'] = 0;

        echo "Login Successful";

    } else {

        $_SESSION['attempts']++;

        if($_SESSION['attempts'] >= 5) {

            $_SESSION['locked_until'] = time() + 900;

            die("Account locked for 15 minutes");
        }

        echo "Wrong Password";
    }
}
?>

<form method="POST">

    <input type="password" name="password" required>

    <button name="login">Login</button>

</form>