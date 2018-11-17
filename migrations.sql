CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NULL ,
  `lastname` varchar(255) NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO users (email, password, firstname, lastname)
VALUES ('nikola@gmail.com', 'abc' , 'nikola', 'Stavanger');

INSERT INTO users (email, password, firstname, lastname)
VALUES ('ivan@gmail.com', 'abc1' , 'ivan', 'Stavanger');

INSERT INTO users (email, password, firstname, lastname)
VALUES ('marko@gmail.com', 'abc' , 'marko', 'Stavanger');