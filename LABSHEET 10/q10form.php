<?php
require "csrf.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    verify_csrf();

    echo "Form submitted successfully";
}
?>

<form method="POST">

    <?php echo csrf_field(); ?>

    <input type="text" name="name" required>

    <button type="submit">Submit</button>

</form>