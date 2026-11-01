<?php

if(isset($_POST['submit'])) {

    $name = $_POST['name'];

    echo "Welcome: ";

    echo htmlspecialchars(
        $name,
        ENT_QUOTES,
        'UTF-8'
    );
}

?>

<h2>XSS Protection Example</h2>

<form method="post">

    Enter Name:
    <input type="text" name="name">

    <button name="submit">Submit</button>

</form>