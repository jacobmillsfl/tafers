use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_LoadRecentActivity`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_LoadRecentActivity`
(
)
BEGIN
	SELECT * FROM (

		-- Uploads
		(SELECT u.id AS 'UserId'
		, u.imgUrl AS 'ImgUrl'
		, CONCAT(u.username,' uploaded file ',f.filename, ' filetype ', f.fileType) AS 'Description'
		, f.uploadDate AS 'EventDate'
		, 'FILE_UPLOAD' AS 'EventType'
		FROM User u JOIN File f on u.id = f.userId
		ORDER BY f.uploadDate DESC
		LIMIT 5)

		UNION
		-- Song Creation
		(SELECT u.id AS 'UserId'
		, u.imgUrl AS 'ImgUrl'
		, CONCAT(u.username,' created song ',s.name) AS 'Description'
		, s.createDate AS 'EventDate'
		, 'SONG_CREATE' AS 'EventType'
		FROM User u JOIN Song s on u.id = s.createdByUserId
		ORDER BY s.createDate DESC
		LIMIT 5)

		UNION
		-- Song Comment
		(SELECT u.id AS 'UserId'
		, u.imgUrl AS 'ImgUrl'
		, CONCAT(u.username,' commented on song ',s.name) AS 'Description'
		, sc.createDate AS 'EventDate'
		, 'SONG_COMMENT' AS 'EventType'
		FROM User u JOIN SongComment sc on u.id = sc.userId
		JOIN Song s ON sc.songId = s.id
		ORDER BY sc.createDate DESC
		LIMIT 5)

		UNION
		-- Agenda Created
		(SELECT u.id AS 'UserId'
		, u.imgUrl AS 'ImgUrl'
		, CONCAT(u.username,' created Agenda item ',a.title) AS 'Description'
		, a.createDate AS 'EventDate'
		, 'AGENDA_CREATE' AS 'EventType'
		FROM User u JOIN ToDoItem a on u.id = a.createdByUserId
		ORDER BY a.createDate DESC
		LIMIT 5)

		UNION
		-- Agenda Closed
		(SELECT u.id AS 'UserId'
		, u.imgUrl AS 'ImgUrl'
		, CONCAT(u.username,' closed Agenda item ',a.title) AS 'Description'
		, a.closedDate AS 'EventDate'
		, 'AGENDA_CLOSED' AS 'EventType'
		FROM User u JOIN ToDoItem a on u.id = a.closedByUserId
		WHERE a.closedDate IS NOT NULL
		ORDER BY a.closedDate DESC
		LIMIT 5)

		UNION
		-- Uploads
		(SELECT u.id AS 'UserId'
		, u.imgUrl AS 'ImgUrl'
		, CONCAT(u.username,' registered an account on TAFers! Welcome!') AS 'Description'
		, u.createDate AS 'EventDate'
		, 'USER_REGISTER' AS 'EventType'
		FROM User u
		ORDER BY u.createDate DESC
		LIMIT 5
		)
	) Activity
	ORDER BY EventDate DESC
	LIMIT 10;
END //
DELIMITER ;
