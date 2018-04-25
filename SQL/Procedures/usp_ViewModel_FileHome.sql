DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ViewModel_LoadFileHome`
()
BEGIN
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
	FROM `File` INNER JOIN `User` ON `File`.`userId` = `User`.`id`;
END //
DELIMITER ;