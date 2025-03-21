<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Record</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .form-container {
      margin-bottom: 20px;
    }
    .form-container input, .form-container select, .form-container button {
      width: 100%;
      padding: 10px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-container button {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
    }
    .form-container button:hover {
      background-color: #45a049;
    }
    .webcam-container {
      margin: 20px 0;
    }
    .webcam-container video {
      width: 100%;
      max-width: 300px;
    }
    .captured-image {
      margin-top: 10px;
      max-width: 300px;
      display: block;
    }
  </style>
</head>
<body>

<h1>Upload Record</h1>

<!-- Form for name, address and file upload -->
<div class="form-container">
  <label for="name">Name</label>
  <input type="text" id="name" placeholder="Enter name">

  <label for="address">Address</label>
  <input type="text" id="address" placeholder="Enter address">

  <label for="files">Upload Files</label>
  <input type="file" id="files" name="files[]" multiple>

  <button onclick="submitForm()">Submit</button>
</div>

<!-- Webcam Section -->
<div class="webcam-container">
  <label for="webcam">Capture Photo</label>
  <video id="webcam" autoplay></video>
  <button onclick="capturePhoto()">Capture</button>
  <canvas id="canvas" style="display: none;"></canvas>
  <img id="captured-image" class="captured-image" style="display: none;">
</div>

<script>
  // Access webcam for photo capture
  const webcam = document.getElementById('webcam');
  const canvas = document.getElementById('canvas');
  const capturedImage = document.getElementById('captured-image');

  // Get user's webcam video stream
  navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(stream) {
      webcam.srcObject = stream;
    })
    .catch(function(error) {
      console.error("Error accessing webcam:", error);
    });

  // Capture photo from webcam
  function capturePhoto() {
    const context = canvas.getContext('2d');
    canvas.width = webcam.videoWidth;
    canvas.height = webcam.videoHeight;
    context.drawImage(webcam, 0, 0, canvas.width, canvas.height);

    // Convert canvas to image
    const imageUrl = canvas.toDataURL('image/png');
    capturedImage.src = imageUrl;
    capturedImage.style.display = 'block';
  }

  // Handle form submission
  function submitForm(event) {
    // Prevent the default form submission behavior
    event.preventDefault();

    const formData = new FormData();

    // Get form fields
    const name = document.getElementById('name').value;
    const address = document.getElementById('address').value;

    // Append form fields to FormData
    formData.append('name', name);
    formData.append('address', address);

    // Append files (if any)
    const files = document.getElementById('files').files;
    for (let i = 0; i < files.length; i++) {
      formData.append('files[]', files[i]);
    }

    // If a photo was captured, append it to FormData
    if (capturedImage.src) {
      const imageBlob = dataURItoBlob(capturedImage.src);
      const file = new File([imageBlob], 'captured-photo.png', { type: 'image/png' });
      formData.append('photo', file);
    }

    // Send the form data to the backend
    sendToBackend(formData);
  }

  // Send the form data to the backend
  function sendToBackend(formData) {
    const token = 'your-token-here'; // Replace with your actual token

    fetch('http://127.0.0.1:8000/api/submit-record', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Record uploaded successfully!');
      } else {
        alert('Failed to upload record.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred while uploading.');
    });
  }

  // Convert data URL to Blob
  function dataURItoBlob(dataURI) {
    const byteString = atob(dataURI.split(',')[1]);
    const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    const arrayBuffer = new ArrayBuffer(byteString.length);
    const uint8Array = new Uint8Array(arrayBuffer);

    for (let i = 0; i < byteString.length; i++) {
      uint8Array[i] = byteString.charCodeAt(i);
    }

    return new Blob([uint8Array], { type: mimeString });
  }
</script>

</body>
</html>
