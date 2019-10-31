USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_Add
(
IN paramTitle VARCHAR(255), IN paramMessage VARCHAR(255), IN paramImgUrl VARCHAR(255)
)
BEGIN
	INSERT INTO SiteBanner(title,message,imgUrl)
	VALUES(paramTitle, paramMessage, paramImgUrl);
	
	-- Return last inserted ID as result
	SELECT LAST_INSERT_ID() as id;
	
END //
DELIMITER ;USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_LoadAll
()
BEGIN
	SELECT id, title, message, imgUrl
	FROM SiteBanner;
END //
DELIMITER ;USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_Load
(
IN paramId INT
)
BEGIN
	SELECT id, title, message, imgUrl
	FROM SiteBanner
	WHERE id = paramId;
END //
DELIMITER ;USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_Remove
(
IN paramId INT
)
BEGIN
	DELETE
	FROM SiteBanner
	WHERE id = paramId;
END //
DELIMITER ;USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_Search
(IN paramId INT, IN paramTitle VARCHAR(255), IN paramMessage VARCHAR(255), IN paramImgUrl VARCHAR(255))
BEGIN
	SELECT id, title, message, imgUrl
	FROM SiteBanner
	WHERE COALESCE(id,0) = COALESCE(paramId,id,0)
	AND COALESCE(title,'') = COALESCE(paramTitle,title,'')
	AND COALESCE(message,'') = COALESCE(paramMessage,message,'')
	AND COALESCE(imgUrl,'') = COALESCE(paramImgUrl,imgUrl,'');
	
END //
DELIMITER ;USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_Update
(
IN paramId INT, IN paramTitle VARCHAR(255), IN paramMessage VARCHAR(255), IN paramImgUrl VARCHAR(255)
)
BEGIN

	UPDATE SiteBanner
	SET title = paramTitle,
		message = paramMessage,
		imgUrl = paramImgUrl
	WHERE id = paramId;
	
END //
DELIMITER ;



-- Insert default data
INSERT INTO SiteBanner(title,message,imgUrl)
VALUES ("TAFERS DOT NET","Coming Soon","images/Tafers2-02.png");
