<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT
	s.id,
	COUNT(su.noise),
	nl.name,
	s.name
	
FROM
	noise_labels nl
JOIN
	spaces s
";
if (isset($_GET['spaceId']) &&  $_GET['spaceId'] != "0"){
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
WHERE 1=1
";

include 'filters.php';

$q .= "GROUP BY nl.id";
	
$data;

$file = fopen("noisequery.sql", "a");
fwrite($file, $q);
fclose($file);

$db_result = $db->query($q);

$fhandle = fopen("noisequery.sql", "w");
fwrite($fhandle, $q);
fclose($fhandle);


$data[] = $feedback;
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[2], (int)$area[1]);
}


$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>
