<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Title</title>
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css">
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="scripts.js"></script>
</head>
<body>
<div class="container">
	<br><br>
	<br>
	<h4>Количество выполненных запросов: <span id="count">0</span></h4><br><br>

	<button class="btn btn-info" data-method="setAuthors">Добавить 10 случайных авторов</button>
	<button class="btn btn-info" data-method="getAuthors">Показать список авторов</button>
	<br><br>
	<button class="btn btn-info" data-method="setSpecters">Добавить 10 случайных спектров</button>
	<button class="btn btn-info" data-method="getSpecters">Показать список спектров</button>
	<br><br>
	<button class="btn btn-info" data-method="getSpectersByAuthor">Показать спектры автора с id=2</button>
	<button class="btn btn-info" data-method="getStupidAuthors">Показать авторов без спектров</button>
	<br><br>
	<button class="btn btn-danger" data-method="dropTables">Удалить все таблицы</button>
	<br><br>
	<pre id="output">Вывод</pre>
	<br><br>
	<div id="canvases">

	</div>
	<br><br>
	<table class="table table-striped">
		<tbody id="tblout"></tbody>
	</table>
</div>
<div id="map" style="width: 100%;height: 800px;"></div>

<?
include_once "Controller.php";
$c = new Controller();
$data = $c->getSpectersData();
?>
<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvGnKY6lyFOVvMw5yf9V3bDJiAgC0xSL4&callback=initMap"></script>
<script>

	var googleMap;

	function initMap() {
		googleMap = new google.maps.Map(document.getElementById('map'), {
			center: {lat: 0, lng: 0},
			zoom: 2,
			mapTypeControl: false,
			scrollwheel: false
		});
		<? foreach ($data as $key => $val): ?>
		new google.maps.Marker({
			position: {lat: <?=$val[5]; ?>, lng: <?= $val[6]; ?>},
			map: googleMap,
			title: '<?= $val[7]; ?>',
			label: '<?= $val[7]; ?>'
		});
		<? endforeach; ?>
	}
</script>
</body>
</html>