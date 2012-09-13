CREATE TABLE `users` (
  `userid_pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `fb_id` varchar(100) DEFAULT NULL,
  `fb_access_token` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`userid_pk`)
) ENGINE=InnoDB;

CREATE TABLE `books` (
  `bookid_pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `bookname` varchar(100) NOT NULL,
  `type` enum('private', 'public') NOT NULL,
  `userid_fk` bigint(20) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`bookid_pk`)
) ENGINE=InnoDB;

CREATE TABLE `booksusers` (
  `bookid_fk` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid_fk` bigint(20) NULL,
  `fb_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`bookid_fk`, `userid_fk`)
) ENGINE=InnoDB;

CREATE TABLE `items` (
  `itemid_pk` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` enum('video', 'image') NOT NULL,
  `location` varchar(200) NOT NULL,
  `userid_fk` bigint(20) NOT NULL,
  `bookid_fk` bigint(20) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`itemid_pk`)
) ENGINE=InnoDB;

CREATE TABLE `hashes` (
  `hashname_pk` varchar(100) NOT NULL,
  PRIMARY KEY (`hashname_pk`)
) ENGINE=InnoDB;

CREATE TABLE `hashesitems` (
  `itemid_fk` bigint(20) NOT NULL,
  `hashname_fk` varchar(100) NOT NULL,
  PRIMARY KEY (`itemid_fk`, `hashname_fk`)
) ENGINE=InnoDB;

ALTER TABLE `items`
  ADD CONSTRAINT `items_users_useridfk` FOREIGN KEY (`userid_fk`) REFERENCES `users` (`userid_pk`) ON DELETE CASCADE;

ALTER TABLE `items`
  ADD CONSTRAINT `items_books_bookidfk` FOREIGN KEY (`bookid_fk`) REFERENCES `books` (`bookid_pk`) ON DELETE CASCADE;
  
ALTER TABLE `books`
  ADD CONSTRAINT `books_users_useridfk` FOREIGN KEY (`userid_fk`) REFERENCES `users` (`userid_pk`) ON DELETE CASCADE;

ALTER TABLE `booksusers`
  ADD CONSTRAINT `booksusers_users_bookidfk` FOREIGN KEY (`bookid_fk`) REFERENCES `books` (`bookid_pk`) ON DELETE CASCADE;
  
ALTER TABLE `books`
  ADD CONSTRAINT `booksusers_users_useridfk` FOREIGN KEY (`userid_fk`) REFERENCES `users` (`userid_pk`) ON DELETE CASCADE;
  
ALTER TABLE `hashesitems`
  ADD CONSTRAINT `hashesitems_items_itemidfk` FOREIGN KEY (`itemid_fk`) REFERENCES `items` (`itemid_pk`) ON DELETE CASCADE;

ALTER TABLE `hashesitems`
  ADD CONSTRAINT `hashesitems_hashes_hashnamefk` FOREIGN KEY (`hashname_fk`) REFERENCES `hashes` (`hashname_pk`) ON DELETE CASCADE;