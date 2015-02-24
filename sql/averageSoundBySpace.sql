SELECT
s.id,
AVG(su.noise) as average,
s.name,
la.name
FROM
entries e,
spaces s,
spaceuse su,
collab_labels la,
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
GROUP BY
su.spaceid