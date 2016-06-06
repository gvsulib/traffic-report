<?php
include 'connection.php';
$db = getConnection();
$data = array();

$types = array('Groups', 'Alone', 'Individual');

foreach ($types as $value){
	$q = "SELECT " . $value . ", Count(*) AS Frequency
	FROM
        spaceuse su,
        entries e
    WHERE
    	su.entryId = e.entryId
	";
	if (isset($_GET['spaceId'])){
		$q .= "
		AND su.spaceID = " . $_GET['spaceId'];
	}
	include 'filters.php';
	$q .= " GROUP BY su.groups
			ORDER BY Frequency DESC
			LIMIT 1";
	
	$db_result = $db->query($q);
	
	//should only return one row.
	
	while ($row = $db_result->fetch_row()) {
		
		$data[] = array($value, (int)$row[0]);
		}
	
	
}	
	
$data[] = $feedback;
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>