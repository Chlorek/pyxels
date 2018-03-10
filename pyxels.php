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
        if(isset($_GET['edit'])) {
            ?>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Editor &bull; Pyxels</title>
                    <style>
                        body {
                            background-color: #222;
                            color: #eee;
                            font-family: monospace;
                        }

                        #content {
                            margin: 10px auto 0px auto;
                            width: 600px;
                            text-align: center;
                        }

                        #controls {
                            width: 600px;
                            text-align: center;
                            margin-top: 10px;
                            border-top: 2px solid #888;
                            border-bottom: 2px solid #888;
                            font-weight: bold;
                            font-size: 18pt;
                            height: 36px;
                            line-height: 36px;
                            -webkit-touch-callout: none; /* iOS Safari */
                            -webkit-user-select: none; /* Safari */
                             -khtml-user-select: none; /* Konqueror HTML */
                               -moz-user-select: none; /* Firefox */
                                -ms-user-select: none; /* Internet Explorer/Edge */
                                    user-select: none;
                        }

                        #controls > .highlight:hover {
                            text-shadow: red 2px 2px;
                        }

                        #brushSize {
                            width: 25px;
                            display: inline-block;
                        }

                        .separator {
                            height: 26px;
                            width: 2px;
                            background-color: #888;
                            display: inline-block;
                            position: relative;
                            top: 4px;
                        }

                        #colorPicker {
                            position: relative;
                            top: -3px;
                        }
                    </style>
                    <script>
                        var color = '#ff0000'
                        var brushSize = 10;
                        var mouseDown = false;

                        function draw(event) {
                            if(mouseDown) {
                                var x = event.clientX + document.body.scrollLeft + document.documentElement.scrollLeft - canvas.offsetLeft;
                                var y = event.clientY + document.body.scrollTop + document.documentElement.scrollTop - canvas.offsetTop;

                                ctx.beginPath();
                                ctx.arc(x, y, brushSize, 0, 2*Math.PI, false);
                                ctx.fillStyle = color;
                                ctx.fill();
                            }
                        }

                        function startDraw(event) {
                            mouseDown = true;
                            draw(event);
                        }

                        function stopDraw(event) {
                            mouseDown = false;
                        }

                        function updateColor(event) {
                             color = event.target.value;
                        }

                        window.onload = function() {
                            var img = new Image();
                            img.onload = function() {
                                canvas = document.getElementById('editorCanvas');
                                canvas.width = this.width;
                                canvas.height = this.height;
                                ctx = canvas.getContext("2d");
                                ctx.drawImage(img, 0, 0);
                                canvas.addEventListener("mousedown", startDraw, false);
                                canvas.addEventListener("mouseup", stopDraw, false);
                                canvas.addEventListener("mousemove", draw, false);
                                var colorPicker = document.getElementById('colorPicker');
                                colorPicker.addEventListener("input", updateColor, false);
                                colorPicker.addEventListener("change", updateColor, false);
                                color = colorPicker.value;
                            };
                            img.src = "<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/uploads/' . $_GET['edit'] ?>";
                        };

                        function biggerBrush() {
                            brushSize += 2;
                            if(brushSize > 30)
                                brushSize = 30;
                            document.getElementById('brushSize').innerHTML = brushSize;
                        }

                        function smallerBrush() {
                            brushSize -= 2;
                            if(brushSize <= 0)
                                brushSize = 2;
                            document.getElementById('brushSize').innerHTML = brushSize;
                        }

                        function save() {
                            canvas.toBlob(function(blob) {
                                var data = new FormData();
                                data.append("file", blob, '.png');
                                var request = new XMLHttpRequest();
                                request.open('POST', '<?php echo $_SERVER['DOCUMENT_URI'] ?>', true);
                                request.onload = function() {
                                    if(request.status === 200) {
                                        window.location = request.responseText;
                                    } else
                                        alert('An error occurred ('+request.status+')');
                                };
                                request.send(data);
                            });
                        }
                    </script>
                </head>
                <body>
                    <div id="content">
                        <canvas width="0" height="0" id="editorCanvas">
                            HTML5 canvas not supported by your browser.
                        </canvas>
                        <div id="controls">
                            <span class="highlight" onclick="biggerBrush()">+</span>
                            <span id="brushSize">10</span>
                            <span class="highlight" onclick="smallerBrush()">-</span>
                            <span class="separator"></span>
                            <input id="colorPicker" type="color" value="#ff0000">
                            <span class="highlight" onclick="save()">Save</span>
                        </div>
                    </div>
                </body>
            </html>
            <?php
        }
        else
            echo 'Empty request.';
    }
    else {
        /* You can keep your screenshots named as in request, but this way you
        are vulnerable to having your storage scanned for all possible file-names */
        //$output = 'uploads/' . basename($_FILES['file']['name']);

        $ext = pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION);
        $output = 'uploads/' . bin2hex(openssl_random_pseudo_bytes(16)) . '.' . $ext;

        $tmpName = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmpName, $output);
        //echo $_FILES['file']['error'];

        // Output direct URL to image or to edit-page
        if(isset($_GET['edit']))
            echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["DOCUMENT_URI"] . '?edit=' . $_GET['img'];
        else
            echo 'http://' . $_SERVER['SERVER_NAME'] . '/' . $output;
    }
?>
