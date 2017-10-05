USE opendevtools;

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
DELIMITER ;