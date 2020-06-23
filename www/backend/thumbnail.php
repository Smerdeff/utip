<?php

//if (function_exists('exif_imagetype')) {
//    echo "This function is installed";
//} else {
//    echo "It is not";
//}
//
//$type = exif_imagetype('/upload/0ccba2fa1a6c14d646d0ced0a185de2f.jpg');
$image = exif_thumbnail(__dir__.'/uploads/0ccba2fa1a6c14d646d0ced0a185de2f.jpg', $width, $height, $type);
var_dump($image, $width, $height);

if ($image!==false) {
    header('Content-type: ' .image_type_to_mime_type($type));
    echo $image;
    exit;
} else {
    // нет доступного превью, здесь можно обработать ошибку
    echo 'Нет доступного эскиза';
}

