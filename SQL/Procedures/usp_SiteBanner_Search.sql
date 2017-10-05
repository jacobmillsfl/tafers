USE opendevtools;

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
DELIMITER ;