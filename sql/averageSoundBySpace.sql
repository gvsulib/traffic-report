SELECT 
	u.spaceId,
	s.name,
	avg(u.noise)
FROM
	spaceuse u,
    spaces s
WHERE
	u.spaceId = s.id
GROUP BY
	u.spaceId