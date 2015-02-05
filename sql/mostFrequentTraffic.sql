SELECT 
	s.id,
	s.name,
	la.name,
	COUNT( * )
FROM 
	traffic t,
	spaces s,
	entries e
LEFT JOIN
	traffic_labels la
ON
	la.id = t.level
WHERE 
	t.space = s.id
	AND t.entryId = e.entryId
GROUP BY
	t.space,
	t.level
ORDER BY
	t.space,
	count(*) desc