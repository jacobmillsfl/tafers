USE tafers;

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