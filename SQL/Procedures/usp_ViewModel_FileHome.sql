use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_ViewModel_LoadFileHome`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ViewModel_LoadFileHome`
(
	IN paramcontent VARCHAR(32768),
	IN paramfileCategoryId INT,
	IN paramoffset INT
)
BEGIN
	DECLARE maxItems INT;
	DECLARE myoffset INT;
	SET maxItems = 5;
	SET myoffset = ((paramoffset - 1) * maxItems);
	SELECT
		`File`.`id` AS `fileId`,
		`File`.`fileName` AS `fileName`,
		`File`.`uploadIP` AS `uploadIP`,
		`File`.`uploadDate` AS `uploadDate`,
		`File`.`fileExtension` AS `fileExtension`,
		`File`.`fileSize` AS `fileSize`,
		`File`.`fileType` AS `fileType`,
		`File`.`isPublic` AS `isPublic`,
		`File`.`userId` AS `userId`,
		`User`.`userName` AS `username`,
		`User`.`email` AS `email`,
		`User`.`imgUrl` AS `imgUrl`,
		`User`.`createDate` AS `userCreateDate`,
		`User`.`roleId` AS `userRoleId`
	FROM `File`
	INNER JOIN `User` ON `File`.`userId` = `User`.`id`
	WHERE
		COALESCE(File.`fileName`,'') LIKE COALESCE(CONCAT('%',paramcontent,'%'),File.`fileName`,'')
		AND COALESCE(File.`categoryTypeId`,0) = COALESCE(paramfileCategoryId,File.`categoryTypeId`,0)
	ORDER BY `File`.`uploadDate` DESC
	LIMIT maxItems
	OFFSET myoffset;
END //
DELIMITER ;