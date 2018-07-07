use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_Song_MusicHomeSearch`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Song_MusicHomeSearch`
(
	IN paramcontent VARCHAR(32768),
	IN paramoffset INT
)
BEGIN
	DECLARE maxItems INT;
	DECLARE myoffset INT;
	SET maxItems = 10;
	SET myoffset = ((paramoffset - 1) * maxItems);
	SELECT
		`Song`.`id` AS `id`,
		`Song`.`name` AS `name`,
		`Song`.`description` AS `description`,
		`Song`.`createdByUserId` AS `createdByUserId`,
		`Song`.`imgUrl` AS `imgUrl`,
		`Song`.`fileUrl` AS `fileUrl`,
		`Song`.`createDate` AS `createDate`
	FROM `Song`
	WHERE
		COALESCE(Song.`name`,'') LIKE COALESCE(CONCAT('%',paramcontent,'%'),Song.`name`,'')
		OR COALESCE(Song.`description`,'') LIKE COALESCE(CONCAT('%',paramcontent,'%'),Song.`description`,'')
	ORDER BY `Song`.`createDate` DESC
	LIMIT maxItems
	OFFSET myoffset;
END //
DELIMITER ;
