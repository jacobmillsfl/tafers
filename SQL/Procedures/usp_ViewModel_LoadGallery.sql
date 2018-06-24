use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_ViewModel_LoadGallery`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ViewModel_LoadGallery`
(
)
BEGIN
	DECLARE paramfileCategoryId INT;
	SET paramfileCategoryId = 5; -- Pictures
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
		paramfileCategoryId = File.`categoryTypeId`
		AND `File`.`isPublic` = 1
	ORDER BY `File`.`uploadDate` DESC;
END //
DELIMITER ;