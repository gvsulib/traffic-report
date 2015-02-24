SELECT
	(-(AVG(groups)-6)/5)*100 as groups,
	(-(AVG(alone)-6)/5)*100 as alone,
	(-(AVG(individual)-6)/5)*100 as individual
FROM
	spaceuse s,
	entries e
WHERE
	s.entryId = e.entryId