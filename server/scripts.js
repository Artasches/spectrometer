/**
 * Created by Artik Man on 14.02.2017.
 */
$(function() {
	var output = $('#output');
	var tbl = $('#tblout');
	var counter = $('#count');
	var canvases = $('#canvases');
	$('.btn').click(function() {
		var method = $(this).data('method');
		$.ajax({
			url: '/ajax.php',
			dataType: 'json',
			type: 'POST',
			data: {
				method: method
			},
			complete: function(data) {
				console.dir(data);
				output.html('Вывод');
				tbl.empty();
				canvases.empty();
				var resp = data.responseJSON;
				// try {
				// 	resp = JSON.parse(data.responseText);
				// } catch (e) {
				// 	resp = data.responseText;
				// 	output.html(resp);
				// }
				var i = (parseInt(counter.text()) || 0) + resp.count;
				counter.text(i);

				if (Array.isArray(resp.data)) {
					if (resp.log != 'canvas') {
						resp.data.forEach(function(row) {
							var r = $('<tr/>');
							row.forEach(function(cell) {
								var c = $('<td/>').text(cell);
								c.appendTo(r);
							});
							r.appendTo(tbl);
						})
					} else {
						draw(resp.data);
					}
				}

				output.html(resp.log);

			}
		});
	});
	function draw(data) {
		data.forEach(function(item, i) {

			var ar = [];
			try {
				ar = JSON.parse(item[1]);
			} catch (e) {
				console.error(item)
			}
			console.log(ar);
			var dom = $('<canvas/>').attr({
				'id': 'canvas-' + i,
				'width': ar[ar.length - 1].pixel,
				'height': '50'
			}).css({'width': '100%', 'height': '50px'});
			dom.appendTo(canvases);
			var canvas = document.getElementById('canvas-' + i);
			if (canvas.getContext) {
				var ctx = canvas.getContext('2d');
				for (var j = 0; j < ar.length; j++) {
					var color = 'rgb(' + Math.floor(ar[j].r * 255) + ',' + Math.floor(ar[j].g * 255) + ',' + Math.floor(ar[j].b * 255) + ')';
					ctx.beginPath();
					ctx.moveTo(j, 0);
					ctx.lineTo(j, 50);
					ctx.lineWidth = 1;
					ctx.strokeStyle = color;
					ctx.stroke();
					ctx.closePath();
				}
			}
		});
	}
});