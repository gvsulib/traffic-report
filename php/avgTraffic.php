<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT
s.id,
AVG(t.level) as average,
s.name,
la.name
FROM
entries e,
traffic t,
spaces s,
traffic_labels la,
(
	SELECT
	space,
	ROUND(AVG(level)) as rounded
	FROM
	traffic
	GROUP BY
	space
	) a
WHERE
e.entryId = t.entryId";

include 'filters.php';

$q .= "
AND t.space = s.id
AND t.space = a.space
AND la.id = a.rounded
GROUP BY
t.space";
$data;
$db_result = $db->query($q);
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[0], (float)$area[1], '<div class="chart-tooltip"><span class="area-title">' . $area[2] . '</span><br><span class="area-avg-label">' . $area[3] . '</span><br><span class="area-avg-value">' . $area[1] . "</span></div>");
}
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>