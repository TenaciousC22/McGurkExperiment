CREATE DATABASE IF NOT EXISTS ChrisMcGurkExperiment;

use ChrisMcGurkExperiment;

CREATE TABLE IF NOT EXISTS participants(
	pid INT UNSIGNED AUTO_INCREMENT ,
	age VARCHAR(4) NOT NULL,
	gender VARCHAR(30) NOT NULL,
	spokenLang VARCHAR(30) NOT NULL,
	sid VARCHAR(10),
	PRIMARY KEY (pid)
) AUTO_INCREMENT=1000;

CREATE TABLE IF NOT EXISTS [pid](
	id INT UNSIGNED AUTO_INCREMENT,
	speaker INT UNSIGNED NOT NULL,
	phrase INT UNSIGNED NOT NULL,
	response VARCHAR(300),
	PRIMARY KEY (id)
);
"
CREATE TABLE IF NOT EXISTS playlist(
	id INT UNSIGNED AUTO_INCREMENT,
	pid VARCHAR(255) NOT NULL,
	speaker INT UNSIGNED NOT NULL,
	sentence INT UNSIGNED NOT NULL,
	offset  NOT NULL,
	FOREIGN KEY (pid) REFERENCES participants(id),
	PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS responses(
	id INT UNSIGNED AUTO_INCREMENT,
	pid VARCHAR(255) NOT NULL,
	vidID INT UNSIGNED NOT NULL,
	userAnswer VARCHAR(255),
	FOREIGN KEY (pid) REFERENCES participants(id),
	FOREIGN KEY (vidID) REFERENCES playlist(id),
	PRIMARY KEY (id)
);
"