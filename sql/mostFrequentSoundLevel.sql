    (SELECT 
        s.id,
        s.name as name,
        nl.name as noise,
        count(*) as counted
    FROM 
        entries e,
        spaces s,
        spaceuse su,
        noise_labels nl
    WHERE 
        su.spaceId = s.id
        AND su.noise = nl.id
        AND e.entryId = su.entryId
    GROUP BY
        su.spaceId,
        su.noise
    ORDER BY
        su.spaceId,
        counted DESC) a