var elements = {};

var app = {
  // https://github.com/cordova-plugin-camera-preview/cordova-plugin-camera-preview
  startCamera: function () {
    CameraPreview.startCamera({
      width: window.screen.width,
      height: window.screen.height / 2,
      camera: "front",
      tapPhoto: false,
      tapFocus: true,
      previewDrag: false,
      toBack: true
    });
  },
  takePicture: function () {
    CameraPreview.takePicture(function (imgData) {
      elements.picture.src = 'data:image/jpeg;base64,' + imgData;
      elements.form.toggleClass('hidden');
    });
  },
  switchCamera: function () {
    CameraPreview.switchCamera();
  },
  savePicture: function () {

  },
  init: function () {
    // CameraPreview.setPreviewSize({
    //   width: window.screen.width,
    //   height: window.screen.height / 2
    // })

    elements.takePicture.addEventListener('click', this.takePicture, false);
    elements.switchCamera.addEventListener('click', this.switchCamera, false);
    this.startCamera();
  }

};



document.addEventListener('deviceready', function () {
  elements = {
    takePicture: document.getElementById('takePicture'),
    switchCamera: document.getElementById('switchCamera'),
    picture: document.getElementById('originalPicture'),
    form: document.getElementById('form')
  };

  app.init();


}, false);