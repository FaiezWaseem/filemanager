<?php

//this file help us to display images and video from non public folders
// Additionally also manages to download all type of files


if(isset($_GET['file'])){
    echo readfile($_GET['file']);
}
if(isset($_GET["dw"])){
    $file = $_GET["dw"];

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
}
?>