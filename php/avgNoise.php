<?php
include 'connection.php';
$db = getConnection();
$q = "
SELECT
s.id,
AVG(su.noise) as average,
s.name,
la.name
FROM
entries e,
spaces s,
spaceuse su,
noise_labels la,
(
	SELECT
	spaceid,
	ROUND(AVG(noise)) as rounded
	FROM
	spaceuse
	GROUP BY
	spaceid
	) a
WHERE
e.entryId = su.entryId
AND su.spaceid = s.id
AND su.spaceid = a.spaceid
AND la.id = a.rounded
";
include 'filters.php';

$q .= "
GROUP BY
su.spaceid";
$data;
$db_result = $db->query($q);
while ($area = $db_result->fetch_row()) {
	$data[] = array($area[0], (float)$area[1], '<div class="chart-tooltip"><span class="area-title">' . $area[2] . '</span><br><span class="area-avg-label">' . $area[3] . '</span><br><span class="area-avg-value">' . $area[1] . "</span></div>");
}
$data = json_encode($data);
header('Content-Type: application/json');
echo $data;

?>