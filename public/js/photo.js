

$(function() {
    const cameraOptions = document.querySelector('.video-options>select');
    const video = document.querySelector('video');
    const canvas = document.querySelector('canvas');
    const screenshotImage = document.querySelector('.screenshot-image');
    let streamStarted = false;

    const constraints = {
        video: {
            width: {
                min: 1280,
                ideal: 1920,
                max: 2560,
            },
            height: {
                min: 720,
                ideal: 1080,
                max: 1440
            },
        }
    };

    cameraOptions.onchange = () => {
        const updatedConstraints = {
            ...constraints,
            deviceId: {
                exact: cameraOptions.value
            }
        };

        startStream(updatedConstraints);
    };


    const doScreenshot = () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        screenshotImage.src = canvas.toDataURL('image/png');
        screenshotImage.classList.remove('d-none');
        document.getElementById('image').value = canvas.toDataURL('image/png');
        document.getElementById('card-img').src = canvas.toDataURL('image/png');
    };
    document.getElementById("screenshot").addEventListener("click", function() {
        doScreenshot();
    });

    const startStream = async (constraints) => {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleStream(stream);
    };


    const handleStream = (stream) => {
        video.srcObject = stream;
        screenshot.classList.remove('d-none');

    };




    const getCameraSelection = async () => {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const videoDevices = devices.filter(device => device.kind === 'videoinput');
        const options = videoDevices.map(videoDevice => {
            return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
        });
        cameraOptions.innerHTML = options.join('');
    };

    getCameraSelection();
    const getCamera = async () => {

        if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
            const updatedConstraints = {
                ...constraints,
                deviceId: {
                    exact: cameraOptions.value
                }
            };
            startStream(updatedConstraints);
        }
    };
    getCamera();
});
