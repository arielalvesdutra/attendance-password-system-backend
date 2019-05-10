CREATE DATABASE IF NOT EXISTS aps DEFAULT CHARACTER SET utf8;

USE aps;

CREATE TABLE IF NOT EXISTS attendance_password_categories (
    id INT(4) NOT NULL AUTO_INCREMENT,
    name VARCHAR(40) NOT NULL UNIQUE,
    code VARCHAR(10) NOT NULL UNIQUE,
    PRIMARY KEY (id)
)  ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS ticket_window (
    id INT(4) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (id)
)  ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS attendance_password_status (
    id INT(4) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    code varchar (20) NOT NULL UNIQUE,
    PRIMARY KEY (id)
)  ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS attendance_passwords (
    id INT(12) NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL UNIQUE,
    id_category INT(4) NOT NULL,
    id_ticket_window INT(4),
    id_status INT(4) NOT NULL,
    creation_date VARCHAR(26),
    PRIMARY KEY (id),
    FOREIGN KEY (id_category)
        REFERENCES attendance_password_categories (id) ON DELETE CASCADE,
    FOREIGN KEY (id_ticket_window)
        REFERENCES ticket_window (id),
    FOREIGN KEY (id_status)
        REFERENCES attendance_password_status (id)
)  ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(60) NOT NULL,
  email VARCHAR(60) NOT NULL UNIQUE,
  password VARCHAR (40) NOT NULL,
  admin BOOL DEFAULT false,
  PRIMARY KEY (id)
)engine=InnoDB;

CREATE TABLE IF NOT EXISTS ticket_window_use (
  id_user INT NOT NULL UNIQUE,
  id_ticket_window INT NOT NULL UNIQUE,
  PRIMARY KEY (id_user, id_ticket_window),
  FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (id_ticket_window) ticket_window(id) ON DELETE CASCADE
)engine=InnoDB;
