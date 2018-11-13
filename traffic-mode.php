<?

//if no query has been submitted, get averages for entire database
if (!isset($_GET["submit"])) {
	$request = array(
		"mode" => "mode",
		"spaceID" => "1"
    	
	);

	$feedback = "";


} else {
	$request = array(
		"mode" => "mode",
		"spaceID" => $_GET["spaceId"]
    	
	);
	$feedback = "";

	//check for filter data-yes this is messy
	if (isset($_GET['days'])){
		if (isset($_GET['days']['include'])){
			$request["include"] = array();


			for ($i = 0; $i < count($_GET['days']['include']['begin']); $i++){
				if (!($_GET['days']['include']['begin'][$i] == "" || $_GET['days']['include']['begin'][$i] == "")){
					
					$request["include"][] = array($_GET['days']['include']['begin'][$i], $_GET['days']['include']['end'][$i]);
					$feedback .= "Data between dates:" . $_GET['days']['include']['begin'][$i] . " and " . $_GET['days']['include']['end'][$i] . " included<br>";
				}
			}
		}
		if (isset($_GET['days']['exclude'])){

			$request["exclude"] = array();
			for ($i = 0; $i < count($_GET['days']['exclude']['begin']); $i++){
				if (!($_GET['days']['exclude']['begin'][$i] == "" || $_GET['days']['exclude']['begin'][$i] == "")){

				$request["exclude"][] = array($_GET['days']['exclude']['begin'][$i], $_GET['days']['exclude']['end'][$i]);
				$feedback .= "Data between dates:" . $_GET['days']['exclude']['begin'][$i] . " and " . $_GET['days']['exclude']['end'][$i] . " excluded<br>";
							
				}
			}
		}
	}
	if (isset($_GET['hours'])){
		if (isset($_GET['hours']['include'])){

			$request["hoursInclude"] = array();
			for ($i = 0; $i < count($_GET['hours']['include']['begin']); $i++){
				if (!($_GET['hours']['include']['begin'][$i] == "" || $_GET['hours']['include']['begin'][$i] == "")){
					
					$request["hoursInclude"][] = array($_GET['hours']['include']['begin'][$i], $_GET['hours']['include']['end'][$i]);
				
					$feedback .= "Data between times:" . $_GET['hours']['include']['begin'][$i] . " and " . $_GET['hours']['include']['end'][$i] . " included<br>";
										
				}
			}
		}
		if (isset($_GET['hours']['exclude'])){
			$request["hoursExclude"] = array();
			for ($i = 0; $i < count($_GET['hours']['exclude']['begin']); $i++){
				if (!($_GET['hours']['exclude']['begin'][$i] == "" || $_GET['hours']['exclude']['begin'][$i] == "")){
					
					$request["hoursExclude"][] = array($_GET['hours']['exclude']['begin'][$i], $_GET['hours']['exclude']['end'][$i]);
				

					$feedback .= "Data between times:" . $_GET['hours']['exclude']['begin'][$i] . " and " . $_GET['hours']['exclude']['end'][$i] . " excluded<br>";
										
				}
			}
		}
	}

	//and now that we are done with that business...

}

$json = json_encode($request);

$curl = curl_init("https://prod.library.gvsu.edu/trafficapi/calculate/");

curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($json))); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_HEADER, 1);

$response = curl_exec($curl);

$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
curl_close ($curl);

if ($code != "200") {
	echo "Could Not get traffic data, API returned: " . $header;
	//die();
}

$results = json_decode($body, JSON_OBJECT_AS_ARRAY);

if (gettype($results) == "array") {


	//format for display
	$printable = array();
	foreach ($results as $result) {
		
		$print = true;
		
		$printable[] = array($result["level"], (float) $result["Number"]);
		

	} 
	$printable = json_encode($printable);
	
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
	<form>
		<h2>Traffic Count By Area</h2>
		<select name="spaceId" class="form-control">
						<option value="1" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "1") {echo "selected";}} ?>>Atrium Living Room</option>
						<option value="2" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "2") {echo "selected";}} ?>>Atrium Multipurpose Room</option>
						<option value="3" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "3") {echo "selected";}} ?>>Atrium Exhibition Room</option>
						<option value="4" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "4") {echo "selected";}} ?>>Atrium Tables Under the Stairs</option>
						<option value="5" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "5") {echo "selected";}} ?>>Atrium Outside 001 and 002</option>
						<option value="6" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "6") {echo "selected";}} ?>>1st Floor Knowledge Market</option>
						<option value="7" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "7") {echo "selected";}} ?>>1st Floor Cafe</option>
						<option value="8" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "8") {echo "selected";}} ?>>2nd Floor West Wing Collaborative Space</option>
						<option value="9" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "9") {echo "selected";}} ?>>2nd Floor East Wing Quiet Space</option>
						<option value="10" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "10") {echo "selected";}} ?>>3rd Floor East Wing Quiet Space</option>
						<option value="11" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "11") {echo "selected";}} ?>>3rd Floor West Wing Collaborative Space</option>
						<option value="12" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "12") {echo "selected";}} ?>>3rd Floor Reading Room</option>
						<option value="13" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "13") {echo "selected";}} ?>>3rd Floor Innovation Zone</option>
						<option value="14" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "14") {echo "selected";}} ?>>4th Floor West Wing Collaborative Space</option>
						<option value="15" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "15") {echo "selected";}} ?>>4th Floor East Wing Quiet Space</option>
						<option value="16" <? if (isset($_GET["spaceId"])) {if ($_GET["spaceId"] == "16") {echo "selected";}} ?>>4th Floor Reading Room</option>
						
					</select>
					<button type="submit" name="submit" value="submit" class="add btn btn-info">Filter</button>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="chart"></div>
				<P style="font-size: 20pt" id="filters"></P>
			</div>
		</div>
		<?php 
		$includeSpaceFilter = true;
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
				
	

				var message = document.getElementById('filters');
				<? if ($feedback) {
				echo 'message.innerHTML = "' . $feedback . '";';


				} ?>
				
				data = new google.visualization.DataTable();
				data.addColumn('string', 'Traffic Level');
				data.addColumn('number', 'Amount', {role: 'annotationtext'});

				<? if ($print) {echo "data.addRows($printable);";} ?>
			}

			var options = {
				height: 500,
				vAxis:{
					viewWindow: {
						min: 0,
					},
					title: 'Traffic Level'
				},
				hAxis:{
					title: 'Category'
				}
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('chart'));

			<? if ($print) { echo "chart.draw(data, options);";} ?>
			return false;
		}
	</script>
</body>
</html>
