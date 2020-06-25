<?php
$file_out = "myDirectory/myImage.gif"; // The image to return

if (file_exists($file_out)) {

    $image_info = getimagesize($file_out);

    //Set the content-type header as appropriate
    header('Content-Type: ' . $image_info['mime']);

    //Set the content-length header
    header('Content-Length: ' . filesize($file_out));

    //Write the image bytes to the client
    readfile($file_out);
}
else { // Image file not found

    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");

}