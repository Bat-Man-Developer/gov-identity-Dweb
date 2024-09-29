const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const takePhotoBtn = document.getElementById('takePhotoBtn');
const savePhotoBtn = document.getElementById('savePhotoBtn');
const message = document.getElementById('message');
const ctx = canvas.getContext('2d');

async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
    } catch (err) {
        console.error("Error accessing the camera:", err);
        alert("Error accessing the camera. Please make sure you have given permission to use the camera.");
    }
}

takePhotoBtn.addEventListener('click', () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    savePhotoBtn.style.display = 'inline-block';
});

savePhotoBtn.addEventListener('click', () => {
    const userID = document.getElementById('userID').value;
    const imageDataUrl = canvas.toDataURL('../uploads/user_' + userID + '/ID_photo_' + userID + '.png');
    
    fetch('server/get_register_id_photo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'image=' + encodeURIComponent(imageDataUrl)
    })
    .then(response => response.text())
    .then(data => {
        message.textContent = data;
    })
    .catch(error => {
        console.error('Error:', error);
        message.textContent = 'An error occurred while saving the photo.';
    });
});

startCamera();