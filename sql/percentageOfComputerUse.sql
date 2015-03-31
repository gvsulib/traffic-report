SELECT 
	yes.c/(yes.c+no.c)*100 as yes,
    no.c/(yes.c+no.c)*100 as no
FROM
	(SELECT
        entryId,
        count(computers) as c
    FROM
        spaceuse
    WHERE
        computers = 1) as yes,
    (SELECT
        entryId,
        count(*) as c
    FROM
        spaceuse
    WHERE
        computers = 0) as no,
    entries e
WHERE
    yes.entryId = e.entryId
    OR no.entryId = e.entryId