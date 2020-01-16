
<?

if (!isset($_GET["submit"])) {
	$reqURL = "https://prod.library.gvsu.edu/trafficapi/feedback/";
	$inputError = false;

	

} else {
	if ($_GET["begin"] == "" || $_GET["end"] == "") {
		$inputError = "You must set both a begin and end date.";
		$reqURL = "https://prod.library.gvsu.edu/trafficapi/feedback/";
	} else if (strtotime($_GET["end"]) < strtotime($_GET["begin"])) {
		$inputError = "start date must be before end date.";
		$reqURL = "https://prod.library.gvsu.edu/trafficapi/feedback/";
	} else {
		$reqURL = "https://prod.library.gvsu.edu/trafficapi/feedback/bydate?start=" . $_GET["begin"] . "&end=" . $_GET["end"];
	}

}
//print($reqURL);

$curl = curl_init($reqURL);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_HEADER, 1);

$response = curl_exec($curl);

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
curl_close ($curl);

$results = json_decode($body, JSON_OBJECT_AS_ARRAY);






if (gettype($results) == "array") {
	$print = true;
	$feedback = false;

	$totals = array("1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0);
	//count results 
	$printable = array();
	foreach ($results as $result) {
		$totals[$result["emotion_id"]] += 1;
	}

	foreach ($totals as $key=>$total) {
		
		$printable[] = array( (string) $key, (integer) $total);

	}

	$printable = json_encode($printable);
	//print_r($printable);
	
} else {
	$print = false;	
	$feedback = "No Entries found for your search parameters.";
	
}

?>



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
	<?  if (isset($inputError)) {echo "<div class=\"alert alert-danger\" role=\"alert\">" . $inputError ."</div>";}?>
		<form>
			<h2>Feedback Totals: <?  ?></h2>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div id="chart"></div>
					<P style="font-size: 20pt" id="filters"></P>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<h2>Specify Dates</h2>
					<table class="table" id="days-include">
						<thead>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr class="template">
								<td><input type="date" class="form-control begin" <? if (isset($_GET["begin"])) {echo "value=" . $_GET["begin"];} ?> name="begin"/></td>
								<td><input type="date" class="form-control end" <? if (isset($_GET["end"])) {echo "value=" . $_GET["end"];} ?> name="end"/></td>
								
							</tr>
							
				
			
							
						</tbody>
					</table>
					<button type="submit" name="submit" value="submit" class="add btn btn-info">Filter by date</button>
				</div>
				
		</form>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="js/scripts.js"></script>
	<script type="text/javascript">
		var data;
		function drawChart() {
			
				
			var message = document.getElementById('filters');

			<? if ($feedback) {
				echo 'message.innerHTML = "' . $feedback . '";';


			} ?>
				
			data = new google.visualization.DataTable();
			data.addColumn('string', 'Feedback ID');
			data.addColumn('number', 'Total Times Selected', {role: 'annotationtext'});
			

			<? if ($print) {echo "data.addRows($printable);";} ?>
			

			var options = {
				height: 500,
				vAxis:{
					viewWindow: {
						min: 0,
						max: 20000,
					},
					title: 'Total Times Selected'
				},
				hAxis:{
					title: 'Feedback ID'
				}
				
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart'));

			<? if ($print) { echo "chart.draw(data, options);";} ?>
			return false;
		}
	</script>
</body>
</html>
