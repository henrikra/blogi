/* Script that creates database and tables for blogi */
CREATE DATABASE blogi;

USE blogi;

CREATE TABLE post (
	postId int AUTO_INCREMENT,
	author varchar(100) NOT NULL,
	postDatetime datetime DEFAULT current_timestamp,
	title varchar(150) NOT NULL,
	content text NOT NULL, /* Max lengt is 65 535 character */
	PRIMARY KEY (postId)
);

CREATE TABLE tag(
	tagId int AUTO_INCREMENT,
	tagName varchar(40),
	PRIMARY KEY (tagId)
);

CREATE TABLE postTag(
	postId int,
	tagId int,
	PRIMARY KEY(postId, tagId),
	FOREIGN KEY (postId) REFERENCES post(postId),
	FOREIGN KEY (tagId) REFERENCES tag(tagId)
);

INSERT INTO post
(author, title, content)
VALUES ('Pekka Pekkonen', 'Testipostaus', 'Tämä on testipostaus. Se sisältää tekstiä. Tämä on esimmäinen kappale.

Tämä on toinen kappale. Myös tässä on tekstiä, joka on testin vuoksi tehty.');

INSERT INTO post
(author, title, content)
VALUES ('Keijo Kalmari', 'Otsikko', 'Tämä on testipostaus. Se sisältää tekstiä. Tämä on esimmäinen kappale.

Tämä on toinen kappale. Myös tässä on tekstiä, joka on testin vuoksi tehty. Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.Myös tässä on tekstiä, joka on testin vuoksi tehty.');

INSERT INTO post
(author, title, content)
VALUES ('Sauli Niinistö', 'Päiväni presidenttinä', 'Menin kahville. Se oli hyvää. Sitten menin...');

INSERT INTO tag
(tagName)
VALUES ('Food');

INSERT INTO tag
(tagName)
VALUES ('Culture');

INSERT INTO tag
(tagName)
VALUES ('Programming');


