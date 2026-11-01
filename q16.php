<?php

if(isset($_POST['upload'])) {

    $file = $_FILES['file'];

    $maxSize = 2 * 1024 * 1024;

    if($file['error'] !== UPLOAD_ERR_OK) {
        die("Upload error");
    }

    if($file['size'] > $maxSize) {
        die("File too large");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);

    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'application/pdf' => 'pdf'
    ];

    if(!isset($allowed[$mime])) {
        die("Invalid file type");
    }

    // Store outside the public web root
    $folder = dirname(__DIR__) . "/storage/uploads/";

    if(!is_dir($folder)) {
        mkdir($folder, 0700, true);
    }

    $newName = bin2hex(random_bytes(16)) .
               "." . $allowed[$mime];

    if(move_uploaded_file(
        $file['tmp_name'],
        $folder . $newName
    )) {
        echo "File uploaded successfully";
    } else {
        echo "Upload failed";
    }
}
?>

<form method="POST" enctype="multipart/form-data">

    <input type="file" name="file" required>

    <button name="upload">Upload</button>

</form>