<?
include 'connection.php';
$db = getConnection();

//for spaces that have comnputers, we are logging when we see groups using them.
//this report shows what percentage of the time groups are using the computers 
//versus what percentage of the time they aren't.  We get this by just counting the 
//rows that have a true value and doing some math with a count of the times they have a 
//"no" value.

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
        AND su.entryId = e.entryId
        AND (spaceID = 11 OR spaceID = 8 OR spaceID = 14)";
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
        AND su.entryId = e.entryId
        AND (spaceID = 11 OR spaceID = 8 OR spaceID = 14)";

include 'filters.php';
$q .="
        ) as no";
                
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