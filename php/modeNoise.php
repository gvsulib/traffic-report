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

include 'filters.php';

$q .= "
GROUP BY
	s.id,
	nl.id";
$data;

$db_result = $db->query($q);

$data[] = $feedback;
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[2], (int)$area[1]);
}


$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>