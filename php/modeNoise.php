<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT
	s.id,
	COUNT(su.spaceid),
	nl.name,
	s.name
	
FROM
	noise_labels nl
JOIN
	spaces s
";
if (isset($_GET['spaceId'])){
	$q .= "
	ON s.id = " . $_GET['spaceId'];
}
$q.="
LEFT JOIN
	spaceuse su
  	ON
  		nl.id = su.noise
    AND 
    	s.id = su.spaceid
LEFT JOIN
	entries e
  	ON
  		e.entryID = su.entryId
";

if (isset($_GET['days'])){
	if (isset($_GET['days']['include'])){
		for ($i = 0; $i < count($_GET['days']['include']['begin']); $i++){
			if (!($_GET['days']['include']['begin'][$i] == "" || $_GET['days']['include']['begin'][$i] == "")){
				$q .= ("
					AND e.time BETWEEN TIMESTAMP('" . $_GET['days']['include']['begin'][$i] . "') AND TIMESTAMP('" . $_GET['days']['include']['end'][$i] . "')");
			}
		}
	}
	if (isset($_GET['days']['exclude'])){
		for ($i = 0; $i < count($_GET['days']['exclude']['begin']); $i++){
			if (!($_GET['days']['exclude']['begin'][$i] == "" || $_GET['days']['exclude']['begin'][$i] == "")){
			$q .= ("
				AND e.time NOT BETWEEN TIMESTAMP('" . $_GET['days']['exclude']['begin'][$i] . "') AND TIMESTAMP('" . $_GET['days']['exclude']['end'][$i] . "')");
			}
		}
	}
}
if (isset($_GET['hours'])){
	if (isset($_GET['hours']['include'])){
		for ($i = 0; $i < count($_GET['hours']['include']['begin']); $i++){
			if (!($_GET['hours']['include']['begin'][$i] == "" || $_GET['hours']['include']['begin'][$i] == "")){
				$q .= ("
					AND HOUR(e.time) BETWEEN " . $_GET['hours']['include']['begin'][$i] . " AND " . $_GET['hours']['include']['end'][$i]);
			}
		}
	}
	if (isset($_GET['hours']['exclude'])){
		for ($i = 0; $i < count($_GET['hours']['exclude']['begin']); $i++){
			if (!($_GET['hours']['exclude']['begin'][$i] == "" || $_GET['hours']['exclude']['begin'][$i] == "")){
			$q .= ("
				AND HOUR(e.time) NOT BETWEEN TIMESTAMP('" . $_GET['hours']['exclude']['begin'][$i] . " AND " . $_GET['hours']['exclude']['end'][$i]);
			}
		}
	}
}

$q .= "
GROUP BY
	s.id,
	nl.id";
$data;
$db_result = $db->query($q);
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[2], (int)$area[1]);
}
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>