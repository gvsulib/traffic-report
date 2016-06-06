<?php
include 'connection.php';
$db = getConnection();
$types = array('Groups', 'Alone', 'Individual');
//build a feedback string so we can show what filters are applied on the results page
$file = fopen("avg-type.sql", "w");

for ($i = 0; $i < 3; $i++){
	$q = "
	SELECT
		AVG(s." . $types[$i] . "),
		la.name
	FROM
		spaceuse s,
		entries e,
		collab_labels la,
		(
	        SELECT
	        	ROUND(AVG(" . $types[$i] . ")) as rounded
	        FROM
	        	spaceuse
	    ) a
	WHERE
		s.entryId = e.entryId
		AND la.id = a.rounded
		AND " . $types[$i] . "!= -1";
	if (isset($_GET['spaceId'])){
		$q .= "
		AND s.spaceID = " . $_GET['spaceId'];
	}
	//build a feedback string so we can show what filters are applied on the results page
	$feedback = "";
	
	if (isset($_GET['days'])){
		if (isset($_GET['days']['include'])){
			for ($j = 0; $j < count($_GET['days']['include']['begin']); $j++){
				if (!($_GET['days']['include']['begin'][$j] == "" || $_GET['days']['include']['begin'][$j] == "")){
					$q .= ("
						AND e.time BETWEEN TIMESTAMP('" . $_GET['days']['include']['begin'][$j] . "') AND TIMESTAMP('" . $_GET['days']['include']['end'][$j] . "')");
						$feedback .= ("Data between dates:" . $_GET['days']['include']['begin'][$i] . " and " . $_GET['days']['include']['end'][$i] . " included<br>");
				}
			}
		}
		if (isset($_GET['days']['exclude'])){
			for ($j = 0; $j < count($_GET['days']['exclude']['begin']); $j++){
				if (!($_GET['days']['exclude']['begin'][$j] == "" || $_GET['days']['exclude']['begin'][$j] == "")){
				$q .= ("
					AND e.time NOT BETWEEN TIMESTAMP('" . $_GET['days']['exclude']['begin'][$j] . "') AND TIMESTAMP('" . $_GET['days']['exclude']['end'][$j] . "')");
					$feedback .= ("Data between dates:" . $_GET['days']['exclude']['begin'][$i] . " and " . $_GET['days']['exclude']['end'][$i] . " excluded<br>");
				}
			}
		}
	}
	if (isset($_GET['hours'])){
		if (isset($_GET['hours']['include'])){
			for ($j = 0; $j < count($_GET['hours']['include']['begin']); $j++){
				if (!($_GET['hours']['include']['begin'][$j] == "" || $_GET['hours']['include']['begin'][$j] == "")){
					$q .= ("
						AND HOUR(e.time) BETWEEN " . $_GET['hours']['include']['begin'][$j] . " AND " . $_GET['hours']['include']['end'][$j]);
						$feedback .= ("Data between times:" . $_GET['hours']['include']['begin'][$i] . " and " . $_GET['hours']['include']['end'][$i] . " included<br>");
						
				}
			}
		}
		if (isset($_GET['hours']['exclude'])){
			for ($j = 0; $j < count($_GET['hours']['exclude']['begin']); $j++){
				if (!($_GET['hours']['exclude']['begin'][$j] == "" || $_GET['hours']['exclude']['begin'][$j] == "")){
				$q .= ("
					AND HOUR(e.time) NOT BETWEEN " . $_GET['hours']['exclude']['begin'][$j] . " AND " . $_GET['hours']['exclude']['end'][$j]);
				$feedback .= ("Data between times:" . $_GET['hours']['exclude']['begin'][$i] . " and " . $_GET['hours']['exclude']['end'][$i] . " excluded<br>");
								
				}
			}
		}
	}
	$type = array();
	fwrite($file, $q);
	fwrite($file, $feedback);
	$db_result = $db->query($q);
	while ($row = $db_result->fetch_row()) {
		$type[0] = $types[$i];
		$type[1] = (float)$row[0];
		$type[2] = '<div class="chart-tooltip"><span class="area-title">' . $types[$i] . '</span><br><span class="area-avg-label">' . $row[0] . '</span><br><span class="area-avg-value">' . $row[1] . "</span></div>";
	}
	$data[$i] = $type;
}
$data[] = $feedback;
fclose($file);
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>