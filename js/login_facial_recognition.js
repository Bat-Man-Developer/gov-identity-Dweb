// Get the video and canvas elements
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const takePhotoBtn = document.getElementById('takePhotoBtn');
const verifyPhotoBtn = document.getElementById('savePhotoBtn');
const facialRecognitionBtn = document.getElementById('facialRecognitionBtn');
const facialRecognitionPopup = document.getElementById('facialRecognitionPopup');
const closeBtn = document.querySelector('.close');
const ctx = canvas.getContext('2d');

// Access the user's camera
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => {
        video.srcObject = stream;
        video.play();
    })
    .catch(error => {
        console.error('Error accessing camera:', error);
});

// Take a photo and save it to the canvas
takePhotoBtn.addEventListener('click', () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    canvas.style.display = 'block';
    verifyPhotoBtn.style.display = 'inline-block';
});

// Verify the photo by sending photo to the php server side script
verifyPhotoBtn.addEventListener('click', () => {
    const imageDataUrl = canvas.toDataURL('image/png');

    fetch('server/get_login_facial_recognition.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `face_data=${encodeURIComponent(imageDataUrl)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            facialRecognitionPopup.style.display = 'none';
            window.location.href = `dashboard.php?success=Logged in successfully!`;
        } else {
            facialRecognitionPopup.style.display = 'none';
            window.location.href = `login.php?error=Facial recognition failed. User not found in database. Try again or login manually`;
        }
    })
    .catch(error => {
        facialRecognitionPopup.style.display = 'none';
        window.location.href = `login.php?error=Facial recognition failed unexpectedly. Try again or login manually`;
    });
});

// Open the facial recognition popup
facialRecognitionBtn.addEventListener('click', () => {
    facialRecognitionPopup.style.display = 'block';
});

// Close the facial recognition popup
closeBtn.addEventListener('click', () => {
    facialRecognitionPopup.style.display = 'none';
});