<?php
require_once "db.php";

$message = "";

if(isset($_POST['upload'])) {

    $name = $_POST['name'];
    $file = $_FILES['image'];

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->file($file['tmp_name']);

    if($file['error'] !== UPLOAD_ERR_OK) {
        $message = "Upload failed.";
    }
    elseif($file['size'] > 2*1024*1024) {
        $message = "Maximum image size is 2 MB.";
    }
    elseif(!isset($allowed[$type])) {
        $message = "Only JPG and PNG images are allowed.";
    }
    else {

        $folder = "uploads/";

        if(!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $filename = bin2hex(random_bytes(16))
                    . "." . $allowed[$type];

        if(move_uploaded_file(
            $file['tmp_name'],
            $folder . $filename
        )) {

            $stmt = $conn->prepare(
                "INSERT INTO products(name,image)
                 VALUES(?,?)"
            );

            $stmt->execute([$name,$filename]);

            $message = "Image uploaded successfully!";
        }
    }
}
?>

<h2>Upload Product Image</h2>

<p><?= htmlspecialchars($message) ?></p>

<form method="post" enctype="multipart/form-data">

    Product Name:
    <input type="text" name="name" required>

    Select Image:
    <input type="file" name="image"
    accept=".jpg,.jpeg,.png" required>

    <button name="upload">Upload</button>

</form>