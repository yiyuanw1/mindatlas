SELECT
    u.username AS Username,
    GROUP_CONCAT(CASE WHEN f.field = 'Phone' THEN d.data ELSE NULL END) AS Phone,
    GROUP_CONCAT(CASE WHEN f.field = 'Email' THEN d.data ELSE NULL END) AS Email,
    GROUP_CONCAT(CASE WHEN f.field = 'Position' THEN d.data ELSE NULL END) AS Position
FROM
    User u
JOIN
    userdata d ON u.ID = d.userid
JOIN
    userfieldname f ON d.fieldid = f.ID
GROUP BY
    u.ID;
