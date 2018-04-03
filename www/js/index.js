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
      CameraPreview.stopCamera();

      elements.picture.src = 'data:image/jpeg;base64,' + imgData;
      elements.picture.addEventListener("load", function () {
        var specterData = getSpecterFromPicture(elements.picture, elements.canvas);

      });
      elements.form.toggleClass('hidden');
      setTimeout(function () {
        app.startCamera();
      }, 2000);
    });
  },
  switchCamera: function () {
    CameraPreview.switchCamera()
  },
  savePicture: function () {

  },
  getSpecterFromPicture: function (picture, canvas, options) {
    options = options || {};
    var sx = options.specterX || 0,
      sy = options.specterY || 250,
      sWidth = options.specterWidth || 640,
      sHeight = options.specterHeight || 1,
      dx = 0,
      dy = 0,
      dWidth = sWidth,
      dHeight = options.canvasHeight || 100;

    var ctx = canvas.getContext("2d");
    ctx.drawImage(picture, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight);

    var ar = [];
    for (var i = 0; i < dWidth; i++) {
      var e = ctx.getImageData(i, 0, 1, 1);
      ar.push({
        r: e.data[0],
        g: e.data[1],
        b: e.data[2],
        average: parseInt((e.data[0] + e.data[1] + e.data[2]) / 3),
        pixel: i
      })
    }
    return ar;
  },
  init: function () {
    elements.takePicture.addEventListener('click', this.takePicture, false);
    elements.switchCamera.addEventListener('click', this.switchCamera, false);
    this.startCamera();
    CameraPreview.getSupportedPictureSizes(function (dimensions) {
      elements.console.innerHTML += 'dimensions:<br>'
      dimensions.forEach(function (dimension) {
        elements.console.innerHTML += dimension.width + ' | ' + dimension.height + '<br>';
      });
    });
  }

};

document.addEventListener('deviceready', function () {
  elements = {
    takePicture: document.getElementById('takePicture'),
    switchCamera: document.getElementById('switchCamera'),
    picture: document.getElementById('originalPicture'),
    canvas: document.getElementById('canvas'),
    console: document.getElementById('console'),
    form: document.getElementById('form')
  };

  app.init();


}, false);