@extends('layouts.app')
<style>
    #sig-canvas {
        border: 2px dotted #CCCCCC;
        border-radius: 15px;
        cursor: crosshair;
    }
    .main-heading{
        font-weight: bold;
    }
    .error{
        color: #ff0000;
    }
    .signature_saved{
        color: #008000;
    }
</style>
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <form action="/claims" method="post" id="claimForm">
                    {{ csrf_field() }}
                    <h2 class="main-heading mb-4">Claim Your Flight!</h2>
                    <div class="form-group">
                        <input type="text" class="form-control claim_input" id="full_name" placeholder="Enter Full Name" name="name">
                        <span class="name_error error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control claim_input" id="address" placeholder="Enter Address" name="address">
                        <span class="address_error error"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control claim_input" id="pnr" placeholder="Enter PNR" name="pnr">
                        <span class="pnr_error error"></span>
                    </div>
                    <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2>E-Signature</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="sig-canvas" >
                                        Get a better browser!
                                    </canvas>
                                </div>
                                <span class="signature_error error pl-3"></span> <span class="signature_saved pl-3"></span>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" id="sig-submitBtn">Save</button>
                                    <button type="button" class="btn btn-default" id="sig-clearBtn">Clear</button>

                                    <textarea id="sig-dataUrl" class="form-control claim_input" name="signature" hidden></textarea>
                                </div>
                            </div>

                        </div>
                    <div class="form-group">
                        <input class="btn btn-primary  pr-5 pl-5" type="submit" value="Submit" >
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <script type="text/javascript">
        // signature code starts here
        window.onload = function() {
            window.requestAnimFrame = (function(callback) {
                return window.requestAnimationFrame ||
                    window.webkitRequestAnimationFrame ||
                    window.mozRequestAnimationFrame ||
                    window.oRequestAnimationFrame ||
                    window.msRequestAnimaitonFrame ||
                    function(callback) {
                        window.setTimeout(callback, 1000 / 60);
                    };
            })();

            var canvas = document.getElementById("sig-canvas");
            var ctx = canvas.getContext("2d");
            ctx.strokeStyle = "#222222";
            ctx.lineWidth = 4;

            var drawing = false;
            var mousePos = {
                x: 0,
                y: 0
            };
            var lastPos = mousePos;

            canvas.addEventListener("mousedown", function(e) {
                drawing = true;
                lastPos = getMousePos(canvas, e);
            }, false);

            canvas.addEventListener("mouseup", function(e) {
                drawing = false;
            }, false);

            canvas.addEventListener("mousemove", function(e) {
                mousePos = getMousePos(canvas, e);
            }, false);

            // Add touch event support for mobile
            canvas.addEventListener("touchstart", function(e) {

            }, false);

            canvas.addEventListener("touchmove", function(e) {
                var touch = e.touches[0];
                var me = new MouseEvent("mousemove", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchstart", function(e) {
                mousePos = getTouchPos(canvas, e);
                var touch = e.touches[0];
                var me = new MouseEvent("mousedown", {
                    clientX: touch.clientX,
                    clientY: touch.clientY
                });
                canvas.dispatchEvent(me);
            }, false);

            canvas.addEventListener("touchend", function(e) {
                var me = new MouseEvent("mouseup", {});
                canvas.dispatchEvent(me);
            }, false);

            function getMousePos(canvasDom, mouseEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: mouseEvent.clientX - rect.left,
                    y: mouseEvent.clientY - rect.top
                }
            }

            function getTouchPos(canvasDom, touchEvent) {
                var rect = canvasDom.getBoundingClientRect();
                return {
                    x: touchEvent.touches[0].clientX - rect.left,
                    y: touchEvent.touches[0].clientY - rect.top
                }
            }

            function renderCanvas() {
                if (drawing) {
                    ctx.moveTo(lastPos.x, lastPos.y);
                    ctx.lineTo(mousePos.x, mousePos.y);
                    ctx.stroke();
                    lastPos = mousePos;
                }
            }

            // Prevent scrolling when touching the canvas
            document.body.addEventListener("touchstart", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchend", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);
            document.body.addEventListener("touchmove", function(e) {
                if (e.target == canvas) {
                    e.preventDefault();
                }
            }, false);

            (function drawLoop() {
                requestAnimFrame(drawLoop);
                renderCanvas();
            })();

            function clearCanvas() {
                canvas.width = canvas.width;
            }

            // Set up the UI
            var sigText = document.getElementById("sig-dataUrl");
            var sigImage = document.getElementById("sig-image");
            var clearBtn = document.getElementById("sig-clearBtn");
            var submitBtn = document.getElementById("sig-submitBtn");
            clearBtn.addEventListener("click", function(e) {
                clearCanvas();
                sigText.innerHTML = "";
                $('.signature_saved').text("");
              //  sigImage.setAttribute("src", "");
            }, false);
            submitBtn.addEventListener("click", function(e) {
                const blank = isCanvasBlank(canvas);
                if(blank == false && sigText.value ==""){
                    $('.signature_error').text("");
                    $('.signature_saved').text("Saved!");
                    var dataUrl = canvas.toDataURL();
                    sigText.innerHTML = dataUrl;
                }else if( blank == true && sigText.value==""){
                    $('.signature_error').text("Please draw Signature and Save it.\n");
                    sigText.innerHTML = "";
                }


              //  sigImage.setAttribute("src", dataUrl);
            }, false);
            function isCanvasBlank(canvas) {
                const context = canvas.getContext('2d');

                const pixelBuffer = new Uint32Array(
                    context.getImageData(0, 0, canvas.width, canvas.height).data.buffer
                );

                return !pixelBuffer.some(color => color !== 0);
            }
            // signature code ends here
            // claim form starts here
            var myForm = $('#claimForm');
            myForm.submit(function ( e ) {
                e.preventDefault();
                if(isCanvasBlank(canvas) == false && sigText.value ==""){
                    $('.signature_error').text("Please Save Your Signature.\n");
                    exit;
                }
                var formData = new FormData();
                $signature = sigText.value;
                var image = sigText.value;
                formData.append('name', $('#full_name').val());
                formData.append('address', $('#address').val());
                formData.append('pnr', $('#pnr').val());
                var base64ImageContent = image.replace(/^data:image\/(png|jpg);base64,/, "");
                formData.append('signature', base64ToBlob(base64ImageContent, 'image/png'));
                formData.append('csrf-token', "{{ csrf_token() }}")
                $.ajax({
                    url: myForm.attr('action'),
                    method: 'post',
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    data: formData,
                    success: function(data){
                        Swal.fire({
                            type: 'success',
                            title: 'Success ',
                            text: 'Claim Successful!'
                        }).then(function() {
                                window.location.href = "{{url('claims')}}";
                        });
                    },
                    error: function (reject) {
                        if( reject.status === 422 ) {
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, value) {
                                $("." + key + "_error").text(value);
                            });
                        }
                    }

            });
            });
            // base64 image into binary
            function base64ToBlob(base64, mime)
            {
                mime = mime || '';
                var sliceSize = 1024;
                var byteChars = window.atob(base64);
                var byteArrays = [];

                for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
                    var slice = byteChars.slice(offset, offset + sliceSize);

                    var byteNumbers = new Array(slice.length);
                    for (var i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }

                    var byteArray = new Uint8Array(byteNumbers);

                    byteArrays.push(byteArray);
                }
                return new Blob(byteArrays, {type: mime});
            }
            // error removal
            $( ".claim_input" ).change(function() {
                $( this ).next().text( "" );
            });
        };

    </script>
@endpush
