<?php

$name = filter_var(
    trim($_POST['name'] ?? ''),
    FILTER_SANITIZE_SPECIAL_CHARS
);

$email = filter_var(
    $_POST['email'] ?? '',
    FILTER_VALIDATE_EMAIL
);

$age = filter_var(
    $_POST['age'] ?? '',
    FILTER_VALIDATE_INT
);

$url = filter_var(
    $_POST['url'] ?? '',
    FILTER_VALIDATE_URL
);

if(!$email) {
    echo "Invalid Email";
}
elseif($age === false || $age === null) {
    echo "Invalid Age";
}
elseif(!$url) {
    echo "Invalid URL";
}
else {
    echo "All inputs are valid";
}

?>