SELECT
	data.id,
	data.name,
    data.hour,
    data.noise
FROM
    (SELECT 
        s.id,
        s.name as name,
        HOUR(e.time) as hour,
        su.noise,
        count(su.noise) as counted
    FROM 
        entries e,
        spaces s,
        spaceuse su
    WHERE 
        su.spaceId = s.id
        AND e.entryId = su.entryId
    GROUP BY
        su.spaceId,
        su.noise,
        HOUR(e.time)
    ORDER BY
        count(su.noise) DESC
     ) as data
WHERE
	data.hour = 14
GROUP BY
	data.id