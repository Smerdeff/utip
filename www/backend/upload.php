<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Content-Type': image");
require_once(__dir__ . '/models/Image.php');
require_once('create-thumbnail.php');

$target_dir = "uploads/";
$target_thumbnail_dir = "uploads/thumbnail/";

$imageFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
$unique_file_name = uniqid("img_");

if ($imageFileType) $unique_file_name .= '.' . $imageFileType;
$uploadOk = 1;

$target_file = $target_dir . $unique_file_name;
$check = getimagesize($_FILES["file"]["tmp_name"]);
if (!$check) {
    $uploadOk = 0;
    header("HTTP/1.1 415 Unsupported Media Type");
    echo "File is not an image.";
    return;
}
//if (file_exists($target_file)) {
//    $uploadOk = 0;
//    header("HTTP/1.1 409 Conflict");
//    echo "Sorry, file already exists.";
//    return;
//}
if ($_FILES["file"]["size"] > 500000) {
    $uploadOk = 0;
    header("HTTP/1.1 413 Request Entity Too Large");
    echo "Sorry, your file is too large.";
    return;
}


$hash_file = hash_file('md5', $_FILES["file"]["tmp_name"]);
$filter = [
    "file_hash" => $hash_file,
    ];
$ret = Image::read($filter);


if ($ret['data']) {
    $unique_file_name = $ret['data'][0]['file_name'];
} else {
    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        header("HTTP/1.1 500 'Internal Server Error'");
        echo "Sorry, there was an error uploading your file.";
        return;
    }
}

$data = array(
    "file_name" => $unique_file_name,
    "title" => basename($_FILES["file"]["name"]),
    "file_hash" => $hash_file,
);

createThumbnail($target_dir . $unique_file_name, $target_thumbnail_dir . $unique_file_name, 160);
echo json_encode(Image::create($data), JSON_UNESCAPED_UNICODE);
//echo "The file " . basename($_FILES["file"]["name"]) . " has been  uploaded.";





