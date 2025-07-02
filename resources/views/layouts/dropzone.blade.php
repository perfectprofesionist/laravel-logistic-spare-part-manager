<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fullscreen Dropzone</title>

    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        #fullscreen-dropzone {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 999999;
            justify-content: center;
            align-items: center;
        }

        #fullscreen-dropzone .dropzone {
            width: 80%;
            max-width: 600px;
            border: 3px dashed #ffffff;
            padding: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
        }

        #fullscreen-dropzone .dz-message {
            color: white;
            font-size: 24px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div style="padding: 20px;">
        <h1>Example Page</h1>
        <p>Drag an image file anywhere on the screen to upload via fullscreen Dropzone.</p>
    </div>

    <!-- Fullscreen Dropzone Overlay -->
    <div id="fullscreen-dropzone">
        <form action="{{ url('/upload') }}" class="dropzone" id="fullscreenUploader">
            <div class="dz-message">Drop your image here</div>
        </form>
    </div>

    <!-- Dropzone JS (defer attach until ready) -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Disable auto-discovery
            Dropzone.autoDiscover = false;

            // Destroy if already attached (prevent error on reloads)
            if (Dropzone.instances.length > 0) {
                Dropzone.instances.forEach(dz => dz.destroy());
            }

            const fullscreenDropzone = new Dropzone("#fullscreenUploader", {
                paramName: "file",
                maxFilesize: 100, // MB
                acceptedFiles: 'image/*',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                init: function () {
                    this.on("complete", function (file) {
                        this.removeFile(file);
                    });
                    this.on("queuecomplete", function () {
                        hideDropzoneOverlay();
                    });
                }
            });

            function showDropzoneOverlay() {
                document.getElementById('fullscreen-dropzone').style.display = 'flex';
            }

            function hideDropzoneOverlay() {
                document.getElementById('fullscreen-dropzone').style.display = 'none';
            }

            let dragCounter = 0;

            window.addEventListener('dragenter', function (e) {
                if (e.dataTransfer && [...e.dataTransfer.items].some(item => item.kind === 'file')) {
                    dragCounter++;
                    showDropzoneOverlay();
                }
            });

            window.addEventListener('dragleave', function () {
                dragCounter--;
                if (dragCounter === 0) {
                    hideDropzoneOverlay();
                }
            });

            window.addEventListener('drop', function () {
                dragCounter = 0;
                hideDropzoneOverlay();
            });
        });
    </script>
</body>
</html>
