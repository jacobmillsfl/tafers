use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_UserStats_LoadAll`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_UserStats_LoadUserStats`;


DELIMITER //
CREATE PROCEDURE `tafers`.`usp_UserStats_LoadAll`
()
BEGIN
	SELECT u.username AS 'Username'
	,(SELECT COUNT(*) FROM File f WHERE f.userId = u.id) AS 'FilesUploaded'
	,(SELECT COUNT(*) FROM Song s WHERE s.createdByUserId = u.id) AS 'SongsUploaded'
	,(SELECT COUNT(*) FROM SongComment sc WHERE sc.userId = u.id) AS 'SongComments'
	,(SELECT COUNT(*) FROM ToDoItem tdi WHERE tdi.createdByUserId = u.id) AS 'TasksCreated'
	,(SELECT COUNT(*) FROM ToDoItem tdi WHERE tdi.closedByUserId = u.id) AS 'TasksClosed'
    ,(SELECT COUNT(*) FROM Blog B WHERE B.createdByUserId = u.id) AS 'BlogsCreated'
    ,(SELECT COUNT(*) FROM BlogComment BC WHERE BC.createdByUserId = u.id) AS 'BlogComments'
    ,(SELECT * FROM BlogLike BL INNER JOIN Blog B ON BL.blogId = B.id WHERE B.createdByUserId = u.id) AS 'BlogLikes'
	FROM User u;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tafers`.`usp_UserStats_LoadUserStats`
(
	IN paramid INT
)
BEGIN
	SELECT u.username AS 'Username'
	,(SELECT COUNT(*) FROM File f WHERE f.userId = u.id) AS 'FilesUploaded'
	,(SELECT COUNT(*) FROM Song s WHERE s.createdByUserId = u.id) AS 'SongsUploaded'
	,(SELECT COUNT(*) FROM SongComment sc WHERE sc.userId = u.id) AS 'SongComments'
	,(SELECT COUNT(*) FROM ToDoItem tdi WHERE tdi.createdByUserId = u.id) AS 'TasksCreated'
	,(SELECT COUNT(*) FROM ToDoItem tdi WHERE tdi.closedByUserId = u.id) AS 'TasksClosed'
    ,(SELECT COUNT(*) FROM Blog B WHERE B.createdByUserId = u.id) AS 'BlogsCreated'
    ,(SELECT COUNT(*) FROM BlogComment BC WHERE BC.createdByUserId = u.id) AS 'BlogComments'
    ,(SELECT COUNT(*) FROM BlogLike BL INNER JOIN Blog B ON BL.blogId = B.id WHERE B.createdByUserId = u.id) AS 'BlogLikes'
	FROM User u
	WHERE u.id = paramId;
END //
DELIMITER ;
