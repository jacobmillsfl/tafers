/*
Author:			This code was generated by DALGen version 1.1.0.0 available at https://github.com/H0r53/DALGen 
Date:			3/5/2018
Description:	Creates the Role table and respective stored procedures

*/


USE tafers;



-- ------------------------------------------------------------
-- Drop existing objects
-- ------------------------------------------------------------

DROP TABLE IF EXISTS `tafers`.`Role`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_Role_Load`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_Role_LoadAll`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_Role_Add`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_Role_Update`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_Role_Delete`;
DROP PROCEDURE IF EXISTS `tafers`.`usp_Role_Search`;


-- ------------------------------------------------------------
-- Create table
-- ------------------------------------------------------------



CREATE TABLE `tafers`.`Role` (
id INT AUTO_INCREMENT,
name VARCHAR(255),
description VARCHAR(512),
CONSTRAINT pk_Role_id PRIMARY KEY (id)
);


-- ------------------------------------------------------------
-- Create default SCRUD sprocs for this table
-- ------------------------------------------------------------


DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Role_Load`
(
	 IN paramid INT
)
BEGIN
	SELECT
		`Role`.`id` AS `id`,
		`Role`.`name` AS `name`,
		`Role`.`description` AS `description`
	FROM `Role`
	WHERE 		`Role`.`id` = paramid;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Role_LoadAll`
()
BEGIN
	SELECT
		`Role`.`id` AS `id`,
		`Role`.`name` AS `name`,
		`Role`.`description` AS `description`
	FROM `Role`;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Role_Add`
(
	 IN paramname VARCHAR(255),
	 IN paramdescription VARCHAR(512)
)
BEGIN
	INSERT INTO `Role` (name,description)
	VALUES (paramname, paramdescription);
	-- Return last inserted ID as result
	SELECT LAST_INSERT_ID() as id;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Role_Update`
(
	IN paramid INT,
	IN paramname VARCHAR(255),
	IN paramdescription VARCHAR(512)
)
BEGIN
	UPDATE `Role`
	SET name = paramname
		,description = paramdescription
	WHERE		`Role`.`id` = paramid;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Role_Delete`
(
	IN paramid INT
)
BEGIN
	DELETE FROM `Role`
	WHERE		`Role`.`id` = paramid;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `tafers`.`usp_Role_Search`
(
	IN paramid INT,
	IN paramname VARCHAR(255),
	IN paramdescription VARCHAR(512)
)
BEGIN
	SELECT
		`Role`.`id` AS `id`,
		`Role`.`name` AS `name`,
		`Role`.`description` AS `description`
	FROM `Role`
	WHERE
		COALESCE(Role.`id`,0) = COALESCE(paramid,Role.`id`,0)
		AND COALESCE(Role.`name`,'') = COALESCE(paramname,Role.`name`,'')
		AND COALESCE(Role.`description`,'') = COALESCE(paramdescription,Role.`description`,'');
END //
DELIMITER ;


