use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_ViewModel_LoadAgendaHome`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ViewModel_LoadAgendaHome`
(
	IN parampriorityId INT,
	IN paramisopen INT,
	IN paramoffset INT
)
BEGIN
	DECLARE maxItems INT;
	DECLARE myoffset INT;
	SET maxItems = 10;
	SET myoffset = ((paramoffset - 1) * maxItems);
	SELECT
	`tdi`.`id` AS `toDoItemId`,
	`tdi`.`priorityId`,
	`tdi`.`createdByUserId`,
	`tdi`.`createDate`,
	`tdi`.`title`,
	`tdi`.`summary`,
	`tdi`.`closedByUserId`,
	`tdi`.`closedDate`,
	`u`.`imgUrl` AS `createdByImgUrl`,
	`u`.`username` AS `createdByUsername`
	FROM `ToDoItem` `tdi` INNER JOIN `User` `u` ON tdi.createdByUserId = u.id
	WHERE 
		COALESCE(tdi.priorityId,0) = COALESCE(parampriorityId ,tdi.priorityId,0)
		AND CASE WHEN tdi.closedDate IS NULL THEN COALESCE(paramIsOpen,1) = 1 ELSE COALESCE(paramIsOpen,0) = 0 END
	ORDER BY tdi.createDate DESC
	LIMIT maxItems
	OFFSET myoffset;
END //
DELIMITER ;