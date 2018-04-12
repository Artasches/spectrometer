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
        var position = app.getSpecterPosition(elements.picture);

        position.fromX -= 20;
        position.fromY -= 20;
        position.toX += 20;
        position.toY += 20;

        position.fromX = position.fromX < 0 ? 0 : position.fromX;
        position.fromY = position.fromY < 0 ? 0 : position.fromY;

        var specterData = app.getSpecterFromPicture(elements.picture, elements.canvas, {
          specterX: position.fromX,
          specterY: (position.fromY + position.toY) / 2,
          specterWidth: position.toX - position.fromX
        });

      });
      elements.form.toggleClass('hidden');
      setTimeout(app.startCamera, 2000);
    });
  },
  switchCamera: function () {
    CameraPreview.switchCamera()
  },
  savePicture: function () {

  },
  getSpecterPosition: function (picture) {
    var canvas = document.createElement('canvas');
    canvas.width = picture.naturalWidth;
    canvas.height = picture.naturalHeight;

    var context = canvas.getContext('2d');
    context.drawImage(picture, 0, 0);

    var imageData = context.getImageData(0, 0, canvas.width, canvas.height),
      canvasPixelArray = imageData.data;

    // value = 1.8;
    // for (var i = 0; i < canvasPixelArray.length; i += 4) {
    //   canvasPixelArray[i] = ((((canvasPixelArray[i] / 255) - 0.5) * value) + 0.5) * 255;
    //   canvasPixelArray[i + 1] = ((((canvasPixelArray[i + 1] / 255) - 0.5) * value) + 0.5) * 255;
    //   canvasPixelArray[i + 2] = ((((canvasPixelArray[i + 2] / 255) - 0.5) * value) + 0.5) * 255;
    // }

    var newImageData = [];
    for (var x = 0; x < canvas.width; x++) {
      for (var y = 0; y < canvas.height; y++) {
        var e = context.getImageData(x, y, 1, 1);
        if (e.data[0] + e.data[1] + e.data[2] > 100) {
          newImageData.push(x + ',' + y);
        }
      }
    }

    var from = newImageData[0].split(',');
    var to = newImageData.pop().split(',');
    return {
      fromX: parseInt(from[0]),
      fromY: parseInt(from[1]),
      toX: parseInt(to[0]),
      toY: parseInt(to[1]),
    }
    // context.putImageData(imageData, 0, 0);


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
      // var specterData = app.getSpecterFromPicture(elements.picture, elements.canvas, {
      //   specterX: position.fromX,
      //   specterY: (position.fromY + position.toY) / 2,
      //   specterWidth: position.toX - position.fromX
      // });
    canvas.width = dWidth;
    canvas.height = dHeight;

    var ctx = canvas.getContext("2d");
    ctx.drawImage(picture, sx, sy, sWidth, sHeight, dx, dy, dWidth, dHeight);

    var ar = [];
    for (var i = 0; i < dWidth; i++) {
      var e = ctx.getImageData(i, 0, 1, 1);

      var r = e.data[0],
        g = e.data[1],
        b = e.data[2];

      ar.push({
        r: r,
        g: g,
        b: b,
        average: parseInt((e.data[0] + e.data[1] + e.data[2]) / 3),
        pixel: i
      })
    }
    return ar;
  },
  init: function () {
    elements.takePicture.addEventListener('click', this.takePicture, false);
    // elements.fakePicture.addEventListener('click', this.fakePicture, false);
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
    fakePicture: document.getElementById('fakePicture'),
    switchCamera: document.getElementById('switchCamera'),
    picture: document.getElementById('originalPicture'),
    canvas: document.getElementById('canvas'),
    console: document.getElementById('console'),
    form: document.getElementById('form')
  };

  app.init();


}, false);

