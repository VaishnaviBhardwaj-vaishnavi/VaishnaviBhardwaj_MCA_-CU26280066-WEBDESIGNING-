<?php

$conn = new PDO(
    "mysql:host=localhost;dbname=myproject_db;charset=utf8mb4",
    "myproject_user",
    "CHANGE_THIS_PASSWORD"
);

if(isset($_POST['submit'])) {

    $email = filter_var(
        $_POST['email'],
        FILTER_VALIDATE_EMAIL
    );

    if($email) {

        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE email=?"
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user) {

            $token = bin2hex(random_bytes(32));

            $hash = hash('sha256', $token);

            $expiry = date(
                'Y-m-d H:i:s',
                time() + 1800
            );

            $update = $conn->prepare(
                "UPDATE users
                 SET reset_token_hash=?, reset_expires_at=?
                 WHERE id=?"
            );

            $update->execute([
                $hash,
                $expiry,
                $user['id']
            ]);

            echo "Reset link token: " . htmlspecialchars($token);
        }
    }

    echo "<p>If the email exists, reset instructions will be sent.</p>";
}
?>

<form method="POST">
    <input type="email" name="email" required>
    <button name="submit">Reset Password</button>
</form>


<?php

$conn = new PDO(
    "mysql:host=localhost;dbname=myproject_db;charset=utf8mb4",
    "myproject_user",
    "CHANGE_THIS_PASSWORD"
);

if(isset($_POST['reset'])) {

    $token = $_POST['token'] ?? '';

    $hash = hash('sha256', $token);

    $stmt = $conn->prepare(
        "SELECT id FROM users
         WHERE reset_token_hash=?
         AND reset_expires_at > NOW()"
    );

    $stmt->execute([$hash]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && strlen($_POST['password']) >= 10) {

        $password = password_hash(
            $_POST['password'],
            PASSWORD_DEFAULT
        );

        $update = $conn->prepare(
            "UPDATE users
             SET password_hash=?,
                 reset_token_hash=NULL,
                 reset_expires_at=NULL
             WHERE id=?"
        );

        $update->execute([
            $password,
            $user['id']
        ]);

        echo "Password changed successfully";

    } else {

        echo "Invalid or expired token";
    }
}
?>

<form method="POST">

    <input type="hidden" name="token"
           value="<?= htmlspecialchars($_GET['token'] ?? '', ENT_QUOTES) ?>">

    <input type="password" name="password" minlength="10" required>

    <button name="reset">Change Password</button>

</form>