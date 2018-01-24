<?php
    /*
    pyxels - simple screen capture tool for Linux
    Copyright (C) 2017 Chlorek

    This file is part of pyxels.

    Pyxels is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    Pyxels is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Pyxels.  If not, see <http://www.gnu.org/licenses/>.
    */

    //error_reporting(E_ALL); ini_set('display_errors', 1);
    if(!isset($_FILES['file'])) {
        echo 'No files in received request.';
    }
    else {
        /* You can keep your screenshots named as in request, but this way you
        are vulnerable to having your storage scanned for all possible file-names */
        //$output = 'uploads/' . basename($_FILES['file']['name']);

        $ext = pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
        $output = 'uploads/' . bin2hex(openssl_random_pseudo_bytes(16)) . '.' . $ext;

        $tmpName = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmpName, $output);
        echo 'http://' . $_SERVER['SERVER_NAME'] . '/' . $output;
        //echo $_FILES['file']['error'];
    }
?>
