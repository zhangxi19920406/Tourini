CREATE TABLE User (
	user_id int(20) AUTO_INCREMENT NULL,
	user_name varchar(20) NOT NULL,
	password varchar(20) NOT NULL,
	profile varchar(150),
	PRIMARY KEY (user_id),
	UNIQUE (user_name)
);

CREATE TABLE Location (
	location_id int(20) AUTO_INCREMENT NOT NULL,
	longitude float(20, 3) NOT NULL,
	latitude float(20, 3) NOT NULL,
	city varchar(20),
	attraction varchar(20),
	PRIMARY KEY (location_id)
);

CREATE TABLE CurrentLocation (
	cl_id int(20) AUTO_INCREMENT NOT NULL,
	location_id int(20) NOT NULL,
	user_id int(20) NOT NULL,
	post_time DATETIME NOT NULL,
	see_status int(1) NOT NULL, 
	status int(1) NOT NULL,
	PRIMARY KEY (cl_id),
	FOREIGN KEY (location_id) REFERENCES LOCATION(location_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id)
);

CREATE TABLE Photo (
	photo_id int(20) AUTO_INCREMENT NOT NULL,	
	photo varchar(50) NOT NULL,
	time DATE NOT NULL,
	location_id int(20) NOT NULL,
	caption varchar(200),
	PRIMARY KEY (photo_id),
	FOREIGN KEY (location_id) REFERENCES Location(location_id)
);

CREATE TABLE PostPhoto (
	post_id int(20) AUTO_INCREMENT NOT NULL,
	user_id int(20) NOT NULL,
	photo_id int(20) NOT NULL,
	post_time DATETIME NOT NULL,
	see_status int(1) NOT NULL,
	PRIMARY KEY (post_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id),
	FOREIGN KEY (photo_id) REFERENCES Photo(photo_id)
);

CREATE TABLE Message (
	message_id int(20) AUTO_INCREMENT NOT NULL,
	text varchar(140) NOT NULL,
	location_id int(20) NOT NULL,
	PRIMARY KEY (message_id),
	FOREIGN KEY (location_id) REFERENCES Location(location_id)
);

CREATE TABLE PostMessage (
	post_id int(20) AUTO_INCREMENT NOT NULL,
	user_id int(20) NOT NULL,
	message_id int(20) NOT NULL,
	post_time DATETIME NOT NULL,
	see_status int(1) NOT NULL,
	PRIMARY KEY (post_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id),
	FOREIGN KEY (message_id) REFERENCES Message(message_id)
);

CREATE TABLE Circle (
	circle_id int(20) AUTO_INCREMENT NOT NULL,
	user_id int(20) NOT NULL,
	circle_name varchar(20) NOT NULL,
	PRIMARY KEY (circle_id),
	FOREIGN KEY (user_id) REFERENCES User(user_id)
);

CREATE TABLE Friend (
	id int(20) AUTO_INCREMENT NOT NULL,
	user_id int(20) NOT NULL,
	friend_id int(20) NOT NULL,
	circle_id int(20),
	request_time DATETIME NOT NULL,
	status int(1) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES User(user_id),
	FOREIGN KEY (friend_id) REFERENCES User(user_id),
	FOREIGN KEY (circle_id) REFERENCES Circle(circle_id)
);

CREATE TABLE CurrentLocationCircleStatus (
	clc_id int(20) AUTO_INCREMENT NOT NULL,
	cl_id int(20) NOT NULL,
	circle_id int(20) NOT NULL,
	PRIMARY KEY (clc_id),
	FOREIGN KEY (cl_id) REFERENCES CurrentLocation(cl_id),
	FOREIGN KEY (circle_id) REFERENCES Circle(circle_id)
);

CREATE TABLE PhotoCircleStatus (
	pc_id int(20) AUTO_INCREMENT NOT NULL,
	post_photo_id int(20) NOT NULL,
	circle_id int(20) NOT NULL,
	PRIMARY KEY (pc_id),
	FOREIGN KEY (post_photo_id) REFERENCES PostPhoto(post_id),
	FOREIGN KEY (circle_id) REFERENCES Circle(circle_id)
);

CREATE TABLE MessageCircleStatus (
	m_id int(20) AUTO_INCREMENT NOT NULL,
	post_message_id int(20) NOT NULL,
	circle_id int(20) NOT NULL,
	PRIMARY KEY (m_id),
	FOREIGN KEY (post_message_id) REFERENCES PostMessage(post_id),
	FOREIGN KEY (circle_id) REFERENCES Circle(circle_id)
);

CREATE TABLE PhotoAdvice (
	pa_id int(20) AUTO_INCREMENT NOT NULL,
	photo_id int(20) NOT NULL,
	advisor_id int(20) NOT NULL,
	advice varchar(200) NOT NULL,
	post_time DATETIME NOT NULL,
	PRIMARY KEY (pa_id),
	FOREIGN KEY (photo_id) REFERENCES PostPhoto(post_id),
	FOREIGN KEY (advisor_id) REFERENCES User(user_id)
);

CREATE TABLE MessageAdvice (
	ma_id int(20) AUTO_INCREMENT NOT NULL,
	message_id int(20) NOT NULL,
	advisor_id int(20) NOT NULL,
	advice varchar(200) NOT NULL,
	post_time DATETIME NOT NULL,
	PRIMARY KEY (ma_id),
	FOREIGN KEY (message_id) REFERENCES Message(message_id),
	FOREIGN KEY (advisor_id) REFERENCES User(user_id)
)

