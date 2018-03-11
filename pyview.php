<?php
    /*
    pyxels - simple screen capture tool for Linux
    Copyright (C) 2017-2018 Chlorek

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
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>View &bull; Pyxels</title>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }

            body {
                background-color: #222;
                color: #eee;
                font-family: monospace;
                width: 100%;
            }

            #content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -50%);
                -moz-transform: translate(-50%, -50%);
                -o-transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
            }

            #bar {
                position: absolute;
                top: 100%;
                left: 50%;
                font-weight: bold;
                transform: translate(-50%, -100%);
                -webkit-transform: translate(-50%, -100%);
                -moz-transform: translate(-50%, -100%);
                -o-transform: translate(-50%, -100%);
                -ms-transform: translate(-50%, -100%);
            }

            #bar > a {
                text-decoration: none;
                color: inherit;
            }

            #bar > a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div id="content">
            <?php
                reset($_GET);
                if(!empty(key($_GET))) {
                    $nameParts = explode('_', basename(key($_GET)));
                    $ext = array_pop($nameParts);
                    $filename = implode('_', $nameParts).'.'.$ext;
                    if($ext === "mp4" || $ext === "webm") {
                        $isVideo = true;
                        ?><video autoplay controls loop>
                            <source src="uploads/<?php echo $filename; ?>" type="video/<?php echo $ext; ?>">
                        </video><?php
                    } else
                        echo '<img src="uploads/'.$filename.'" alt="'.$filename.'">';
                } else
                    echo '<h2>Unspecified image.</h2>';
            ?>
        </div>
        <?php
            if(!$isVideo)
                echo
                '<div id="bar">
                    <a href="pyxels.php?edit='.$filename.'">Edit</a>
                </div>';
        ?>
    </body>
</html>
