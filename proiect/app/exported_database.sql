SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS answers;


CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `emotion_type` enum('Joy','Trust','Fear','Sadness','Anger','Anticipation','Acceptance','Disgust') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`answer_id`),
  KEY `form_id` (`form_id`),
  CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`form_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




DROP TABLE IF EXISTS contact_messages;


CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO contact_messages VALUES("1","ilena1234@gmail.com","da","2024-06-19 21:14:31");
INSERT INTO contact_messages VALUES("2","Marian02@yahoo.com","zzz","2024-06-19 21:16:46");
INSERT INTO contact_messages VALUES("3","ilena1234@gmail.com","csa","2024-06-19 21:19:24");
INSERT INTO contact_messages VALUES("4","test@example.com","Test message","2024-06-20 00:31:18");



DROP TABLE IF EXISTS forms;


CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reported` tinyint(1) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `feedback_type` enum('comments','suggestions','questions') NOT NULL DEFAULT 'comments',
  `answer_time` datetime DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `delete_form_token` varchar(255) DEFAULT NULL,
  `delete_form_token_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`form_id`),
  UNIQUE KEY `delete_form_token` (`delete_form_token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO forms VALUES("2","2","0","da","ada","1","2024-06-23 20:33:12","suggestions","2024-06-28 21:33:00","66785c5845b7c.png",NULL,NULL);



DROP TABLE IF EXISTS users;


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_me_token` varchar(255) DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_token_expires` datetime DEFAULT NULL,
  `change_email_token` varchar(255) DEFAULT NULL,
  `change_email_token_expires` datetime DEFAULT NULL,
  `delete_account_token` varchar(255) DEFAULT NULL,
  `delete_account_token_expires` datetime DEFAULT NULL,
  `role` enum('regular','admin') NOT NULL DEFAULT 'regular',
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `remember_me_token` (`remember_me_token`),
  UNIQUE KEY `reset_password_token` (`reset_password_token`),
  UNIQUE KEY `change_email_token` (`change_email_token`),
  UNIQUE KEY `delete_account_token` (`delete_account_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users VALUES("1","marianapopa@yahoo.com","marianapopa@yahoo.com","$2y$10$3uCNBhz/QZalDFp6TVy0GufgRxB6hUTFVO6bqor03744yjAwf.rJy",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"regular","/web/proiect/app/uploads/th.jpeg");
INSERT INTO users VALUES("2","diandradia29@yahoo.com","diandradia29@yahoo.com","$2y$10$091mK0.RUW127pnjOagDbODEm9PzhZEKK7yIHtc3xRO0eUast2SPi",NULL,"52888537385e275f2cfe968eb79db175","2024-06-21 18:38:09","de2ba48cf5617f79736f882635fd26e3","2024-06-23 21:26:59",NULL,NULL,"regular","/web/proiect/app/uploads/86efc26a-e039-4b3f-bf76-3969f5ca9219.jpeg");
INSERT INTO users VALUES("3","Ilena Pop","ilena1234@gmail.com","$2y$10$bDMyehadxH7P9BxrAEAHEuSbDzxEI9qk5igHKZXawswCS6R8.gwWa",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"regular","/web/proiect/app/uploads/9c37795c50af6bf5760e0a5333cc8348.jpg");
INSERT INTO users VALUES("4","Marian02","Marian02@yahoo.com","$2y$10$fxiKtko5dy82naVRjuyX7.ordLc5.cNKisYsigbToXwuUzzZSpQXy",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"regular","/web/proiect/app/uploads/th.jpeg");
INSERT INTO users VALUES("5","admin","contact2feedbackoneverything@gmail.com","$2y$10$ivDm2iyqltwPZHZhuBzIEe6XFC3k3r3rwdadQnqwt9aEopi90hdGu",NULL,NULL,NULL,NULL,NULL,NULL,NULL,"admin","");



