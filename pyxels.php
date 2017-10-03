<?php
    //error_reporting(E_ALL); ini_set('display_errors', 1);
    if(!isset($_FILES['file'])) {
        echo 'No files in received request.';
    }
    else {
        $output = 'uploads/' . basename($_FILES['file']['name']);
        $tmpName = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmpName, $output);
        echo 'http://' . $_SERVER['SERVER_NAME'] . '/' . $output;
        //echo $_FILES['file']['error'];
    }
?>
