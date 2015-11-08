
USE POS2;



INSERT INTO products VALUES ('067232976X','Sams Teach Yourself PHP, MySQL and Apache All-in-One',10,34.99,20.00,1,TRUE,
'Using a straightforward, step-by-step approach, each lesson in this book builds on the previous ones, enabling you to learn the essentials of PHP scripting, MySQL databases, and the Apache web server from the ground up.','2015-10-23 15:00');
INSERT INTO products VALUES ('0672319241','PHP Developer Cookbook',10,49.99,29.99,1,TRUE,
'Provides a complete, solutions-oriented guide to the challenges most often faced by PHP developers\r\nWritten specifically for experienced Web developers, the book offers real-world solutions to real-world needs\r\n','2015-10-23 15:00');
INSERT INTO products VALUES ('12345678', 'Fresh Sicilian Pizza',5,9.99,6.99,2,TRUE,' Traditional Sicilian pizza is often thick crusted and rectangular, \r\n but also round and similar to the neapolitan pizza. \r\n It is often topped with onions, anchovies, tomatoes, herbs, and strong cheese such as Caciocavallo and Toma.','2015-10-24 16:00');
INSERT INTO products VALUES ('987654321', 'Sweet Italian Sausage', 20, 5.99, 3.99,2,TRUE, 'In the United States, Italian sausage of pork sausage seasoned with fennel, salt, pepper and white wine as the primary seasoning.','2015-10-15 15:00');


INSERT INTO categories VALUES (1,'Books','2015-10-24-15');
INSERT INTO categories VALUES (2,'Electronics','2015-10-24-15');
INSERT INTO categories VALUES (3,'Food','2015-10-24-15');
INSERT INTO categories VALUES (4,'Medical','2015-10-24-15');
INSERT INTO categories VALUES (5,'Outdoor','2015-10-24-15');
INSERT INTO categories VALUES (6,'Other','2015-10-24-15');



INSERT INTO user VALUES ('carmelo', sha1('carmelo'),'Carmelo','Lattuca',"lattuca@yahoo.com",'2015-10-24 17:00');
