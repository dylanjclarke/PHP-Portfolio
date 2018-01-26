CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `local_id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`local_id`)
);
