<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- draw canvas css -->
    <link href="./literallycanvas-0.4.14/css/literallycanvas.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!-- Literally Canvas -->
    <script src="./literallycanvas-0.4.14/js/literallycanvas-core.js"></script>
    <!-- file download -->
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-toBlob@1.0.0/canvas-toBlob.js"></script>
    <title>Medraw</title>
</head>

<body>
    <div class="container">
        <!-- <h1>Hello, world!</h1> -->
        <div class="my-drawing" style="height: 256px"></div>

        <!-- kick it off -->
        <script>
            var lc = LC.init(
                document.getElementsByClassName('my-drawing')[0],
                {
                    imageSize: { width: 256, height: 256 },
                    // tools: [LC.tools.Pencil, LC.tools.Pan]
                    //     backgroundShapes: [LC.createShape(
                    //         'Text', {
                    //     x: 200, y: 200, text: "I am in the background",
                    //     font: "bold 12px Helvetica"
                    //   })]
                }
            );
            var tool_pencil = new LC.tools.Pencil(lc);
            var tool_pan = new LC.tools.Pan(lc);
            lc.setTool(tool_pencil);
            lc.tool.strokeWidth = 6;
            lc.setColor('primary', 'rgba(0, 255, 255, 0.5)');

        </script>
        <script>

            function readImage() {
                lc.clear();
                var t = document.getElementById('imglist');
                var bgimg = new Image();
                bgimg.src = t.value;
                var s = LC.createShape('Image', { x: 0, y: 0, image: bgimg, scale: 1 });
                lc.saveShape(s);

                // check if already been modified
                var fn = t.value.split('/').pop();
                fn = fn.slice(0, -4) + '_mask.png';
                $.post('./upload/jss/' + fn + '.json').done(function (resp, stat) {
                    console.log(resp);
                    lc.clear();
                    lc.loadSnapshot(resp);

                }).fail(function () {
                    console.log('snapshot not found.');
                });
            }

        </script>

        <script>
            function changeColor(e) {
                // console.log(e.target.id);
                if (e.target.id == "pan") {
                    lc.setTool(tool_pan);
                    // lc.setZoom(2);
                    // console.log(tool_pan);
                }
                else {
                    lc.setTool(tool_pencil);
                }

                var t = document.getElementById('sw');
                t.value = 6;
                changeWidth(t.value);

                switch (e.target.id) {
                    case "c0":
                        lc.setColor('primary', 'rgba(0, 255, 255, 0.5)');
                        break;
                    case "c1":
                        lc.setColor('primary', 'rgba(255, 255, 0, 0.5)');
                        break;
                    case "c2":
                        lc.setColor('primary', 'rgba(0, 255, 0, 0.5)');
                        break;
                    case "c3":
                        lc.setColor('primary', 'rgba(0, 0, 255, 0.5)');
                        break;
                    case "c4":
                        lc.setColor('primary', 'rgba(255, 0, 255, 0.5)');
                        break;
                    case "c5":
                        lc.setColor('primary', 'rgba(255, 0, 0, 0.5)');
                        break;
                    case "c6":
                        lc.setColor('primary', 'rgba(128, 128, 128, 0.5)');
                        break;
                }
            }

            function changeWidth(v) {
                // console.log(v);
                lc.tool.strokeWidth = parseInt(v);
            }

            function zoomin() {
                lc.zoom(1);
            }

            function zoomout() {
                lc.zoom(-1);
            }

            function undo() {
                var t = lc.getSnapshot(['shapes']);
                if (t.shapes.length > 1) {
                    t.shapes.pop();
                    lc.loadSnapshot(t);
                }
            }

            function clearall() {
                if (confirm("Remove all the drawings?")) {
                    var t = lc.getSnapshot(['shapes']);
                    if (t.shapes.length > 1) {
                        t.shapes = [t.shapes[0]];
                        lc.loadSnapshot(t);
                    }
                }


            }
        </script>
        <div class="row justify-content-md-center">
            <button type="button" class="btn btn-dark mr-5" onclick="clearall()">Clear</button>
            <button type="button" class="btn btn-dark mr-1" onclick="zoomout()">-</button>
            <button type="button" class="btn btn-dark mr-1" onclick="zoomin()">+</button>


            <div class="btn-group btn-group-toggle" data-toggle="buttons" onchange="changeColor(event)">
                <label class="btn btn-outline-danger active">
                    <input type="radio" name="options" id="c0" autocomplete="off" checked> Nucleus
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio" name="options" id="c1" autocomplete="off"> Nucleus
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio" name="options" id="c2" autocomplete="off"> Nucleus
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio" name="options" id="c3" autocomplete="off"> Nucleus
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio" name="options" id="c4" autocomplete="off"> Nucleus
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio" name="options" id="c5" autocomplete="off"> Nucleus
                </label>
                <label class="btn btn-outline-danger">
                    <input type="radio" name="options" id="c6" autocomplete="off"> Remove auto-seg
                </label>

            </div>

            <button type="button" class="btn btn-dark ml-1" id="u" onclick="undo()">Undo</button>
            <!-- <button type="button" class="btn btn-dark ml-1" id="r" onclick="reundo(event)">-></button> -->

            <div>
                <label for="strokewidth">Stroke Width (1-20)</label>
                <input id="sw" type="range" class="custom-range" min="1" max="20" value="6" id="strokewidth"
                    onchange="changeWidth(this.value)">
            </div>

            <button type="button" class="btn btn-primary" onclick="saveImage()">Save</button>
        </div>


        <?php include '_list_images.php'; ?>

        <script>
            var dl = document.createElement('a');
            function saveImage() {
                var t = lc.getSnapshot(['shapes']);
                // json snapshot
                var jss = JSON.stringify(t);
                // console.log(typeof(jss));

                // mask image
                // remove background
                t.shapes.splice(0, 1);
                var mask = LC.renderSnapshotToImage(t, { rect: { x: 0, y: 0, width: 256, height: 256 } });
                mask = mask.toDataURL('image/png');



                // console.log(res);
                // dl.href = res.toDataURL();
                var t = document.getElementById('imglist');
                var fn = t.value.split('/').pop();
                fn = fn.slice(0, -4) + '_mask.png';
                // dl.download = fn;
                // dl.click();
                // console.log(lc.getSnapshot(['shapes']));

                // res.toBlob(function(blob) {
                //     saveAs(blob, fn);
                // }, "image/png");

                // send to server
                // rqst = new XMLHttpRequest();
                // rqst.open('POST', '_upload_res.php', true);
                // rqst.setRequestHeader('Content-type', 'application/json');
                var msg = {
                    fn: fn,
                    mask: mask,
                    jss: jss
                };
                $.post('_upload_res.php', msg);
            }
        </script>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
</body>

</html>
