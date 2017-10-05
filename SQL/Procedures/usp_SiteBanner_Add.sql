USE opendevtools;

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
DELIMITER ;