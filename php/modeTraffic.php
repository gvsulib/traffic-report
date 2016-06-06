<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT
	s.id,
	COUNT(t.space),
	tl.name,
	s.name
	
FROM
	traffic_labels tl
JOIN
	spaces s
";
if (isset($_GET['spaceId'])){
	$q .= "
	ON s.id = " . $_GET['spaceId'];
}
$q.="
LEFT JOIN
	traffic t
  	ON
  		tl.id = t.level
    AND 
    	s.id = t.space
LEFT JOIN
	entries e
  	ON
  		e.entryID = t.entryId
WHERE 1=1
";


include 'filters.php';

$q .= "
GROUP BY
	s.id,
	tl.id";
$data[] = $feedback;
$db_result = $db->query($q);
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[2], (int)$area[1]);
}


$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>