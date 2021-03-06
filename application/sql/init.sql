CREATE DATABASE asimpletrade CHARACTER SET utf8  ;
USE asimpletrade;

CREATE TABLE USER (
id INTEGER NOT NULL auto_increment,
name VARCHAR(40) NOT NULL,
firstname VARCHAR(40) NOT NULL,
login VARCHAR(40) NOT NULL UNIQUE,
password VARCHAR(180) NOT NULL,
mail VARCHAR(80) NOT NULL,
address VARCHAR(120) NOT NULL,
phone VARCHAR(30) NOT NULL,
portable VARCHAR(30) NOT NULL,
subscription_date TIMESTAMP NOT NULL DEFAULT NOW() ,
hash VARCHAR(180),
newsletter BOOLEAN NOT NULL DEFAULT 0,
role ENUM('administrator', 'user') NOT NULL,
PRIMARY KEY(id)) ENGINE=InnoDB;

CREATE TABLE ANNOUNCEMENT (
id INTEGER NOT NULL auto_increment, 
title VARCHAR(80) NOT NULL,
subtitle VARCHAR(80),
content TEXT NOT NULL,
post_date TIMESTAMP NOT NULL DEFAULT NOW(),
conclued BOOLEAN NOT NULL DEFAULT 0,
type ENUM('Service', 'Logement', 'Objet') NOT NULL, 
PRIMARY KEY(id)) ENGINE=InnoDB;

CREATE TABLE PICTURE (
id INTEGER NOT NULL auto_increment,
title VARCHAR(80),
alternative VARCHAR(80),
path VARCHAR(180) NOT NULL,
extension VARCHAR(20) NOT NULL,
id_announcement INTEGER NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(id_announcement) REFERENCES ANNOUNCEMENT(id)) ENGINE=InnoDB;

CREATE TABLE INCOMING (
id INTEGER NOT NULL auto_increment,
title VARCHAR(80) NOT NULL,
subtitle VARCHAR(80),
content TEXT NOT NULL,
post_date TIMESTAMP NOT NULL DEFAULT NOW(),
id_user INTEGER NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(id_user) REFERENCES USER(id)) ENGINE=InnoDB;

CREATE TABLE MESSAGE (
id INTEGER NOT NULL auto_increment,
subject VARCHAR(80) NOT NULL,
content TEXT NOT NULL,
date_post TIMESTAMP NOT NULL DEFAULT NOW(),
id_sender INTEGER NOT NULL,
id_receiver INTEGER NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(id_sender) REFERENCES USER(id),
FOREIGN KEY(id_receiver) REFERENCES USER(id)) ENGINE=InnoDB;

CREATE TABLE TAG (
id INTEGER NOT NULL auto_increment,
title VARCHAR(40) NOT NULL,
PRIMARY KEY(id)) ENGINE=InnoDB;

CREATE TABLE TO_APPLY (
id_user INTEGER NOT NULL,
id_announcement INTEGER NOT NULL,
FOREIGN KEY(id_user) REFERENCES USER(id),
FOREIGN KEY(id_announcement) REFERENCES ANNOUNCEMENT(id)) ENGINE=InnoDB;

CREATE TABLE TO_ASSOCIATE (
id_announcement INTEGER NOT NULL,
id_tag INTEGER NOT NULL,
FOREIGN KEY(id_announcement) REFERENCES ANNOUNCEMENT(id),
FOREIGN KEY(id_tag) REFERENCES TAG(id)) ENGINE=InnoDB;

CREATE TABLE TO_FOLLOW ( 
id_user_followed INTEGER NOT NULL,
id_user_follower INTEGER NOT NULL,
FOREIGN KEY(id_user_followed) REFERENCES USER(id),
FOREIGN KEY(id_user_follower) REFERENCES USER(id)) ENGINE=InnoDB;

CREATE TABLE TO_EVALUATE (
id_user INTEGER NOT NULL,
id_announcement INTEGER NOT NULL,
mark INTEGER NOT NULL,
FOREIGN KEY(id_user) REFERENCES USER(id),
FOREIGN KEY(id_announcement) REFERENCES ANNOUNCEMENT(id)) ENGINE=InnoDB;

CREATE TABLE COMMENT (
id INTEGER NOT NULL auto_increment,
content TEXT NOT NULL, 
post_date TIMESTAMP NOT NULL DEFAULT NOW(),
id_user INTEGER NOT NULL,
id_announcement INTEGER NOT NULL, 
PRIMARY KEY(id),
FOREIGN KEY(id_user) REFERENCES USER(id),
FOREIGN KEY(id_announcement) REFERENCES ANNOUNCEMENT(id)) ENGINE=InnoDB;



delimiter //
CREATE TRIGGER DELETE_ON_ANNOUNCEMENT
  BEFORE DELETE ON ANNOUNCEMENT
    FOR EACH ROW 
      BEGIN

      SELECT COUNT(id_announcement) INTO @countAnnouncementTA FROM TO_ASSOCIATE
      WHERE id_announcement  = old.id;

      SELECT COUNT(id) INTO @countComment FROM COMMENT
      WHERE id_announcement  = old.id;

      SELECT COUNT(id_announcement) INTO @countAnnouncementTAP FROM TO_APPLY
      WHERE id_announcement  = old.id;

      SELECT COUNT(id_announcement) INTO @countAnnouncementTE FROM TO_EVALUATE
      WHERE id_announcement  = old.id;

      IF @countAnnouncementTA > 0
        THEN 
          DELETE FROM TO_ASSOCIATE WHERE id_announcement = old.id;
      END IF;   

      IF @countComment > 0
        THEN 
          DELETE FROM COMMENT WHERE id_announcement = old.id;
      END IF;  

      IF @countAnnouncementTAP > 0
        THEN 
          DELETE FROM TO_APPLY WHERE id_announcement = old.id;
      END IF; 

      IF @countAnnouncementTE > 0
        THEN 
          DELETE FROM TO_EVALUATE WHERE id_announcement = old.id;
      END IF; 
      END;

//
delimiter ;