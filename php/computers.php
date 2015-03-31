<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT 
	yes.c/(yes.c+no.c)*100 as yes,
    no.c/(yes.c+no.c)*100 as no
FROM
	(SELECT
        count(su.computers) as c
    FROM
        spaceuse su,
        entries e
    WHERE
        su.computers = 1
        AND su.entryId = e.entryId";
        include 'filters.php';
$q .="
        ) as yes,
    (SELECT
        count(su.computers) as c
    FROM
        spaceuse su,
        entries e
    WHERE
        su.computers = 0
        AND su.entryId = e.entryId";
        include 'filters.php';
$q .="
        ) as no";
echo $q;
die();
$data;
$db_result = $db->query($q);
while ($area = $db_result->fetch_row()) {
	$data[] = array("Using", (float)$area[0]);
	$data[] = array("Not Using", (float)$area[1]);
}
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>