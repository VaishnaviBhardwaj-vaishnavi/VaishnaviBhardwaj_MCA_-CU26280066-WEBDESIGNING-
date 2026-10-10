<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    $allowed = ['jpg', 'jpeg', 'png'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload Failed!");
    }

    if ($file['size'] > 2 * 1024 * 1024 ||
        !in_array($ext, $allowed, true)) {
        die("Invalid File!");
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $types = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
              'png' => 'image/png'];

    if (($types[$ext] ?? '') !== $mime) {
        die("Invalid Image!");
    }

    $name = bin2hex(random_bytes(16)) . "." . $ext;
    if (move_uploaded_file($file['tmp_name'], __DIR__ . "/uploads/" . $name)) {
        echo "Image Uploaded Successfully!";
    }
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="image" accept=".jpg,.jpeg,.png" required>
    <button type="submit">Upload</button>
</form>