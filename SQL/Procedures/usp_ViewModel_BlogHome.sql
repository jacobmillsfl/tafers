use tafers;

DROP PROCEDURE IF EXISTS `tafers`.`usp_ViewModel_LoadBlogHome`;

DELIMITER //
CREATE PROCEDURE `tafers`.`usp_ViewModel_LoadBlogHome`
(
	IN parambandid INT,
	IN paramoffset INT
)
BEGIN
	DECLARE maxItems INT;
	DECLARE myoffset INT;
	SET maxItems = 10;
	SET myoffset = ((paramoffset - 1) * maxItems);

	SELECT B.id AS blogId,
	U.username AS createdByUsername,
	B.createDate AS createDate,
	B.message AS message,
	B.bandId AS bandId,
	U.imgUrl AS imgurl,
    CASE WHEN BL.userId IS NOT NULL THEN 1 ELSE 0 END AS liked,
    (SELECT COUNT(*) FROM BlogLike BLTemp WHERE BLTemp.blogId = B.id) AS likecount 
	FROM Blog B INNER JOIN User U ON U.id = B.createdByUserId
    LEFT JOIN BlogLike BL ON BL.blogId = B.id AND BL.userId = U.id
	WHERE COALESCE(B.bandId,0) = COALESCE(parambandid, B.bandId,0)
	ORDER BY B.createDate DESC
	LIMIT maxItems
	OFFSET myoffset;
END //
DELIMITER ;
