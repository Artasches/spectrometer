var elements = {};

var app = {

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
  savePicture: function () {
    var params = {
      data: elements.picture.src.replace('data:image/jpeg;base64,', ''),
      prefix: 'myPrefix_',
      format: 'JPG',
      quality: 95,
      mediaScanner: true
    };
    imageSaver.saveBase64Image(params,
      function (filePath) {
        console.log('File saved on ' + filePath);
      },
      function (msg) {
        console.error(msg);
      }
    );
  },
  showSupportedPictureSizes: function () {
    CameraPreview.getSupportedPictureSizes(function (dimensions) {
      dimensions.forEach(function (dimension) {
        console.log(dimension.width + 'x' + dimension.height);
      });
    });
  },
  init: function () {


    elements.takePicture.addEventListener('click', this.takePicture, false);

    this.startCamera();
    this.showSupportedPictureSizes();
  }
  
};



document.addEventListener('deviceready', function () {
  elements = {
    takePicture: document.getElementById('takePicture'),
    picture: document.getElementById('originalPicture'),
    form: document.getElementById('form')
  };

  app.init();

  
}, false);