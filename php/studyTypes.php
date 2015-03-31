<?php
include 'connection.php';
$db = getConnection();
$types = array('Groups', 'Alone', 'Individual');
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
		AND la.id = a.rounded";
	if (isset($_GET['spaceId'])){
		$q .= "
		AND s.spaceID = " . $_GET['spaceId'];
	}
	if (isset($_GET['days'])){
		if (isset($_GET['days']['include'])){
			for ($j = 0; $j < count($_GET['days']['include']['begin']); $j++){
				if (!($_GET['days']['include']['begin'][$j] == "" || $_GET['days']['include']['begin'][$j] == "")){
					$q .= ("
						AND e.time BETWEEN TIMESTAMP('" . $_GET['days']['include']['begin'][$j] . "') AND TIMESTAMP('" . $_GET['days']['include']['end'][$j] . "')");
				}
			}
		}
		if (isset($_GET['days']['exclude'])){
			for ($j = 0; $j < count($_GET['days']['exclude']['begin']); $j++){
				if (!($_GET['days']['exclude']['begin'][$j] == "" || $_GET['days']['exclude']['begin'][$j] == "")){
				$q .= ("
					AND e.time NOT BETWEEN TIMESTAMP('" . $_GET['days']['exclude']['begin'][$j] . "') AND TIMESTAMP('" . $_GET['days']['exclude']['end'][$j] . "')");
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
				}
			}
		}
		if (isset($_GET['hours']['exclude'])){
			for ($j = 0; $j < count($_GET['hours']['exclude']['begin']); $j++){
				if (!($_GET['hours']['exclude']['begin'][$j] == "" || $_GET['hours']['exclude']['begin'][$j] == "")){
				$q .= ("
					AND HOUR(e.time) NOT BETWEEN " . $_GET['hours']['exclude']['begin'][$j] . " AND " . $_GET['hours']['exclude']['end'][$j]);
				}
			}
		}
	}
	$type = array();
	$db_result = $db->query($q);
	while ($row = $db_result->fetch_row()) {
		$type[0] = $types[$i];
		$type[1] = (float)$row[0];
		$type[2] = '<div class="chart-tooltip"><span class="area-title">' . $types[$i] . '</span><br><span class="area-avg-label">' . $row[0] . '</span><br><span class="area-avg-value">' . $row[1] . "</span></div>";
	}
	$data[$i] = $type;
}
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>