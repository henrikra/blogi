/* Script that creates database and tables for blogi */
CREATE DATABASE blogi;

USE blogi;

CREATE TABLE post (
	postId int AUTO_INCREMENT,
	author varchar(100) NOT NULL,
	postDatetime datetime DEFAULT current_timestamp,
	title varchar(150) NOT NULL,
	content text NOT NULL, /* Max lengt is 65 535 character */
	imageLocation varchar(150),
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

CREATE TABLE postComment(
	commentId int AUTO_INCREMENT NOT NULL,
	postId int NOT NULL,
	commentAuthor varchar(100) NOT NULL,
	commentDatetime datetime NOT NULL,
	commentContent text NOT NULL,
	commentReply int NULL,
	PRIMARY KEY (commentId),
	FOREIGN KEY (commentReply) REFERENCES postComment(commentId)
);

INSERT INTO post
(author, title, content)
VALUES ('Pekka Pekkonen', 'Testipostaus', 'Class facilisi ullamcorper molestie. Habitant etiam hendrerit. Egestas consectetur cras amet. Per mus taciti.

Sapien molestie auctor. Class fermentum vivamus vehicula. Sociis morbi turpis.

Quisque ipsum sed leo. Sodales vitae montes suspendisse. Donec euismod curae placerat.');

INSERT INTO post
(author, title, content)
VALUES ('Keijo Kalmari', 'Otsikko', 'Ullamcorper taciti sit ea. Fugiat integer viverra. Laoreet ultrices velit at.

Rhoncus consectetuer pariatur. Lacus natoque nisi bibendum. Aenean placerat porta class.

Nullam morbi vehicula. Minim deserunt sodales. Molestie ante ea pulvinar.

Nunclorem placerat ultricies lorem. Incididunt mi est esse. Officia vivamus occaecat. Mus aenean integer.');

INSERT INTO post
(author, title, content)
VALUES ('Sauli Niinistö', 'Päiväni presidenttinä', 'Ante nascetur lectus aliquip. Dictum exercitation consectetur sodales. Reprehenderit dui mauris. Parturient vehicula lacus.

Ultricies risus eros maecenas. Dui pede nullam. Mollit elit vivamus sollicitudin. Deserunt habitant himenaeos.');

INSERT INTO tag
(tagName)
VALUES ('Food');

INSERT INTO tag
(tagName)
VALUES ('Culture');

INSERT INTO tag
(tagName)
VALUES ('Programming');


