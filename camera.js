document.addEventListener('DOMContentLoaded', (event) => {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const startCameraButton = document.getElementById('startCamera');
    const takePhotoButton = document.getElementById('takePhoto');
    const savePhotoButton = document.getElementById('savePhoto');
    const retakePhotoButton = document.getElementById('retakePhoto');
    const context = canvas.getContext('2d');
    let stream;
    let capturedImage;

    startCameraButton.addEventListener('click', async () => {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            takePhotoButton.disabled = false;
            savePhotoButton.style.display = 'none';
            retakePhotoButton.style.display = 'none';
            video.style.display = 'block';
            canvas.style.display = 'none';
        } catch (error) {
            console.error('Erreur lors de l\'accès à la caméra :', error);
            alert('Impossible d\'accéder à la caméra. Veuillez vérifier vos permissions.');
        }
    });

    takePhotoButton.addEventListener('click', () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        capturedImage = canvas.toDataURL('image/png');
        const img = document.createElement('img');
        img.src = capturedImage;
        document.querySelector('.output').appendChild(img);
        canvas.style.display = 'none';

        // Arrêter le flux vidéo et masquer l'élément vidéo
        if (stream) {
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
        }
        video.style.display = 'none';
        takePhotoButton.style.display = 'none';
        savePhotoButton.style.display = 'inline';
        retakePhotoButton.style.display = 'inline';
    });

    retakePhotoButton.addEventListener('click', async () => {
        document.querySelector('.output').innerHTML = '';
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            video.style.display = 'block';
            canvas.style.display = 'none';
            takePhotoButton.style.display = 'inline';
            savePhotoButton.style.display = 'none';
            retakePhotoButton.style.display = 'none';
        } catch (error) {
            console.error('Erreur lors de l\'accès à la caméra :', error);
            alert('Impossible d\'accéder à la caméra. Veuillez vérifier vos permissions.');
        }
    });

    savePhotoButton.addEventListener('click', () => {
        alert('Photo sauvegardée avec succès!');
        savePhotoButton.style.display = 'none';
        retakePhotoButton.style.display = 'none';
        takePhotoButton.disabled = true;
    });
});
