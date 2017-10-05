USE tafers;

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
DELIMITER ;