CREATE TABLE reservation_made
(
user_id  mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
FName varchar(25)   NOT NULL,
LName varchar(20) NOT NULL,
email varchar(60)  NOT NULL,
r_status varchar(10) NOT NULL,
people_dining mediumint(9) NOT NULL,
date_time  datetime NOT NULL,
PRIMARY KEY (user_id)

);

INSERT INTO reservation_made VALUES(NULL, 'john', 'badji', 'johnbad@gmail.com','Pending',5,'2020-06-25 08-25');
