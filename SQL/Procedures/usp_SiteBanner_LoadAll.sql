USE tafers;

DELIMITER //
CREATE PROCEDURE usp_SiteBanner_LoadAll
()
BEGIN
	SELECT id, title, message, imgUrl
	FROM SiteBanner;
END //
DELIMITER ;