const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const takePhotoBtn = document.getElementById('takePhotoBtn');
const savePhotoBtn = document.getElementById('savePhotoBtn');
const successMessage = document.getElementById('success');
const errorMessage = document.getElementById('error');
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
    canvas.style.display = 'block';
    savePhotoBtn.style.display = 'inline-block';
});

savePhotoBtn.addEventListener('click', () => {
    const userID = document.getElementById('userID').value;
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const dob = document.getElementById('dob').value;
    const pob = document.getElementById('pob').value;
    const gender = document.getElementById('gender').value;
    const nationality = document.getElementById('nationality').value;
    const address = document.getElementById('address').value;
    const fatherName = document.getElementById('fatherName').value;
    const motherName = document.getElementById('motherName').value;
    const maritalStatus = document.getElementById('maritalStatus').value;
    const occupation = document.getElementById('occupation').value;
    const documentType = document.getElementById('documentType').value;
    const applicationStatus = document.getElementById('applicationStatus').value;
    const signaturePath = document.getElementById('signaturePath').value;

    if (!userID) {
        alert("Unauthorised Access. Please provide a User ID.");
        return; // Stop execution if userID is not provided
    }

    const imageDataUrl = canvas.toDataURL('image/png');

    fetch('server/get_register_id_photo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `image=${encodeURIComponent(imageDataUrl)}&userID=${encodeURIComponent(userID)}&firstName=${encodeURIComponent(firstName)}&lastName=${encodeURIComponent(lastName)}&dob=${encodeURIComponent(dob)}&pob=${encodeURIComponent(pob)}&gender=${encodeURIComponent(gender)}&nationality=${encodeURIComponent(nationality)}&address=${encodeURIComponent(address)}&fatherName=${encodeURIComponent(fatherName)}&motherName=${encodeURIComponent(motherName)}&maritalStatus=${encodeURIComponent(maritalStatus)}&occupation=${encodeURIComponent(occupation)}&documentType=${encodeURIComponent(documentType)}&applicationStatus=${encodeURIComponent(applicationStatus)}&signaturePath=${encodeURIComponent(signaturePath)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = `id_application.php?success=ID application submitted successfully. We will process your application and contact you soon.`;
        } else {
            throw new Error(data.error || "An unknown error occurred.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while saving the photo. Please try again.");
    });
});

startCamera();