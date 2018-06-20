
DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ToDoItem_GetCounts`
()
BEGIN
		SELECT COUNT(*) 'total',
		COUNT(CASE WHEN closedDate IS NULL THEN 1 END) 'open',
		COUNT(CASE WHEN closedDate IS NOT NULL THEN 1 END) 'closed'
		FROM ToDoItem;
END //
DELIMITER ;
