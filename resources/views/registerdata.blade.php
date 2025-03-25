<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files and Capture Photo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        #video {
            width: 100%;
            max-height: 300px;
            border: 1px solid #ddd;
        }
        #canvas {
            display: none; /* Hidden initially */
        }
        #capturedImage {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="border border-gray-300 rounded-lg w-[500px] mx-auto mt-5 p-6 shadow-lg bg-white">
    <h2 class="text-2xl font-semibold text-center mb-4">Welcome, {{$user->name}} Upload Record</h2>
    <form id="uploadForm" method="POST" action="{{ route('submit.record') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name Input -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" id="name" name="name" required>
        </div>

        <!-- Address Input -->
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" id="address" name="address" required>
        </div>

        <!-- Multiple File Upload -->
        <div class="mb-4">
            <label for="files" class="block text-sm font-medium text-gray-700">Upload Files:</label>
            <input type="file" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" id="files" name="files[]" multiple>
            <small class="text-gray-600">Upload multiple files (images, documents, etc.).</small>
        </div>

        <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address:</label>
        <select id="states" name="state">
            @forEach($states as $key => $state)
            <option value="{{$key}}">{{$state['name']}}</option>
            @endforEach
        </select>
        </div>

        <!-- Trigger Modal for Capture Photo -->
        <button type="button" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200 mb-4" data-toggle="modal" data-target="#photoModal">
            Capture Photo
        </button>

        <!-- Hidden Photo Input (for the captured photo) -->
        <input type="hidden" id="profilePhoto" name="profilePhoto">

        <!-- Display Captured Image -->
        <h4 class="mt-4 text-lg font-medium">Captured Photo:</h4>
        <img id="capturedImage" src="" alt="Captured Image" class="mt-2 rounded-md shadow-md hidden">

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-md hover:bg-green-700 transition duration-200 mt-3">
            Submit Record
        </button>
    </form>
</div>


    <!-- Modal for Live Camera Capture -->
    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Capture Photo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Live Video Stream -->
                    <video id="video" autoplay></video>

                    <!-- Hidden Canvas for Capturing Photo -->
                    <canvas id="canvas"></canvas>

                    <!-- Buttons -->
                    <div class="mt-3">
                        <button id="captureButton" class="btn btn-primary">Capture</button>
                        <button id="recaptureButton" class="btn btn-secondary" style="display: none;">Recapture</button>
                        <button id="usePhotoButton" class="btn btn-success" style="display: none;">Use Photo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript for Camera and Capture -->
    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureButton = document.getElementById('captureButton');
        const recaptureButton = document.getElementById('recaptureButton');
        const usePhotoButton = document.getElementById('usePhotoButton');
        const capturedImage = document.getElementById('capturedImage');
        const photoInput = document.getElementById('profilePhoto');

        // Access the camera when the modal is opened
        $('#photoModal').on('shown.bs.modal', function () {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Error accessing webcam:", err);
                    alert("Could not access the camera. Please check your permissions.");
                });
        });

        // Stop the camera when the modal is closed
        $('#photoModal').on('hidden.bs.modal', function () {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }
            resetCaptureState();
        });

        // Capture photo
        captureButton.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw the current frame from the video onto the canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Hide the video and show the captured image
            video.style.display = 'none';
            canvas.style.display = 'block';
            
            // Show action buttons
            captureButton.style.display = 'none';
            recaptureButton.style.display = 'inline-block';
            usePhotoButton.style.display = 'inline-block';
        });

        // Recapture photo
        recaptureButton.addEventListener('click', () => {
            resetCaptureState();
        });

        // Use captured photo
        usePhotoButton.addEventListener('click', () => {
    const imageDataURL = canvas.toDataURL('image/jpeg');
    
    // Set the captured image data to the hidden input field
    photoInput.value = imageDataURL;

    // Debugging: Log base64 string to console
    console.log("Captured Base64 Image Data:", imageDataURL);

    // Display the captured image
    capturedImage.src = imageDataURL;
    capturedImage.style.display = 'block';

    // Close the modal
    $('#photoModal').modal('hide');
});


		// Reset state for recapturing
		function resetCaptureState() {
			video.style.display = 'block';
			canvas.style.display = 'none';
			
			captureButton.style.display = 'inline-block';
			recaptureButton.style.display = 'none';
			usePhotoButton.style.display = 'none';
		}
    </script>
</body>
</html>