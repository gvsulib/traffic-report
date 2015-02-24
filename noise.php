<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>Library Traffic Data Dashboard</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>

	<?php include 'nav.php';?>

	<div class="container" id="main">
		<form onsubmit="return false;">
			<h2>Average Noise By Area <small>1 = Loud, 5 = Silent</small></h2>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div id="chart"></div>
				</div>
			</div>
			<?php 
			include 'filters.php';
			?>
		</form>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript">
		var data;
		function drawChart(refresh) {
			if (refresh){
				var xhr = new XMLHttpRequest();
				xhr.open('GET','php/avgNoise.php?' + jQuery('form').serialize(),false);
				xhr.send();
				data = new google.visualization.DataTable();
				data.addColumn('string', 'Area');
				data.addColumn('number', 'Level', {role: 'annotationtext'});
				data.addColumn({type: 'string', role: 'tooltip', p:{html: true}});

				data.addRows(JSON.parse(xhr.responseText));
			}

			var options = {
				height: 500,
				vAxis:{
					viewWindow: {
						min: 0,
						max: 5
					},
					title: 'Noise Level'
				},
				hAxis:{
					title: 'Area'
				},
				tooltip:{
					isHtml: true
				}
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart'));

			chart.draw(data, options);
			return false;
		}
	</script>
</body>
</html>
