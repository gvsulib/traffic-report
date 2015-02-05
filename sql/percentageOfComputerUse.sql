SELECT 
	yes.c/(yes.c+no.c)*100 as yes,
    no.c/(yes.c+no.c)*100 as no
FROM
	(SELECT
        count(*) as c
    FROM
        spaceuse
    WHERE
        computers = 1) as yes,
    (SELECT
        count(*) as c
    FROM
        spaceuse
    WHERE
        computers = 0) as no