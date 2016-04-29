<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT
s.id,
AVG(su.whiteboard) as average,
s.name
FROM
entries e,
spaces s,
spaceuse su
WHERE
e.entryId = su.entryId
AND su.spaceid = s.id
AND s.whiteboard = 1
";
include 'filters.php';

$q .= "
GROUP BY
su.spaceid";
$data;
$db_result = $db->query($q);
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[0], (float)$area[1], '<div class="chart-tooltip"><span class="area-title">' . $area[2] . '</span><br /><span class="area-avg-value">' . $area[1] . "</span></div>");
}
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;
?>