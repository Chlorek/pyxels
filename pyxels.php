<!--
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
-->

<?php
    if(!isset($_FILES['file'])) {
        echo 'No files in received request.';
    }
    else {
        $output = 'uploads/' . $filename;
        $tmpName = $_FILES['file']['tmp_name'][0];
        move_uploaded_file($tmpName, $output);
        echo 'Success';
    }
?>
