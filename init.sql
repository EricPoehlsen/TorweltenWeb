DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS logins;
DROP TABLE IF EXISTS characters;

CREATE TABLE users (
    userid int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username varchar(255) UNIQUE NOT NULL,
    passhash varchar(255) NOT NULL,
    mail varchar(255) NOT NULL,
    access INT NOT NULL
);

CREATE TABLE logins (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userid int NOT NULL,
    token varchar(255) NOT NULL,
    expires TIMESTAMP
);

CREATE TABLE characters (
    charid int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userid int NOT NULL,
    charname varchar(255),
    species varchar(255),
    concept varchar(255),
    phy tinyint DEFAULT 0,
    men tinyint DEFAULT 0,
    soz tinyint DEFAULT 0,
    nk tinyint DEFAULT 0,
    fk tinyint DEFAULT 0,
    lp tinyint DEFAULT 0,
    ep tinyint DEFAULT 0,
    mp tinyint DEFAULT 0,
    cur_lp decimal(3,1) DEFAULT 0.0,
    cur_ep decimal(3,1) DEFAULT 0.0,
    cur_mp decimal(3,1) DEFAULT 0.0
);