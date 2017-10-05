USE tafers;

CREATE TABLE SiteBanner (
id INT AUTO_INCREMENT,
title VARCHAR(255),
message VARCHAR(255),
imgUrl VARCHAR(255),
CONSTRAINT pk_SiteBanner_id PRIMARY KEY (id)
);