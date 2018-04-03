var getSpecterFromPicture = function (picture, canvas, options) {
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
}
function init() {
    var picture = document.getElementById('originalPicture');
    var canvas = document.getElementById('canvas');

    var specterData = getSpecterFromPicture(picture, canvas, {});

    console.log(specterData);
}

// document.addEventListener('ready', function () {
init();
// }, false);