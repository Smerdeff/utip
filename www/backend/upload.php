<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type': image");
$target_dir = "uploads/";

$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$check = getimagesize($_FILES["file"]["tmp_name"]);
if (!$check) {
    $uploadOk = 0;
    header("HTTP/1.1 415 Unsupported Media Type");
    echo "File is not an image.";
    return;
}
if (file_exists($target_file)) {
    $uploadOk = 0;
    header("HTTP/1.1 409 Conflict");
    echo "Sorry, file already exists.";
    return;
}
if ($_FILES["file"]["size"] > 500000) {
    $uploadOk = 0;
    header("HTTP/1.1 413 Request Entity Too Large");
    echo "Sorry, your file is too large.";
    return;
}
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    echo "The file " . basename($_FILES["file"]["name"]) . " has been  uploaded.";
} else {
    header("HTTP/1.1 500 'Internal Server Error'");
    echo "Sorry, there was an error uploading your file.";
}




