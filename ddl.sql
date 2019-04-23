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
    PRIMARY KEY (id),
    FOREIGN KEY (id_category)
        REFERENCES attendance_password_categories (id),
    FOREIGN KEY (id_ticket_window)
        REFERENCES ticket_window (id),
    FOREIGN KEY (id_status)
        REFERENCES attendance_password_status (id)
)  ENGINE=INNODB;
