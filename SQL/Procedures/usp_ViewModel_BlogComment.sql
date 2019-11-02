use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_ViewModel_LoadBlogCommentViewModel`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ViewModel_LoadBlogCommentViewModel`
(
	IN paramblogid INT
)
BEGIN
	SELECT B.id AS blogId,
	BC.id AS commentId,
	U.username AS username,
	U.imgUrl AS imgurl,
	BC.createDate AS createDate,
	BC.message AS message
	FROM BlogComment BC INNER JOIN Blog B ON B.id = BC.blogId
	INNER JOIN User U ON U.id = BC.createdByUserId
	WHERE B.id = paramblogid
	ORDER BY BC.createDate ASC;
END //
DELIMITER ;
