SELECT
	s.id,
	avg(t.level) avg
FROM
	entries e,
	traffic t,
	spaces s
WHERE
	e.entryId = t.entryId
	AND t.space = s.id
GROUP BY
	t.space