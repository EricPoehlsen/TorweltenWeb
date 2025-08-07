DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS logins;
DROP TABLE IF EXISTS characters;
DROP TABLE IF EXISTS xplog;

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
    phy tinyint DEFAULT 4,
    men tinyint DEFAULT 4,
    soz tinyint DEFAULT 4,
    nk tinyint DEFAULT 4,
    fk tinyint DEFAULT 4,
    lp tinyint DEFAULT 4,
    ep tinyint DEFAULT 4,
    mp tinyint DEFAULT 4,
    cur_lp decimal(3,1) DEFAULT 0.0,
    cur_ep decimal(3,1) DEFAULT 0.0,
    cur_mp decimal(3,1) DEFAULT 0.0
);

CREATE TABLE xplog (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    charid int NOT NULL,
    userid int NOT NULL,
    xp int NOT NULL,
    reason varchar(255),
    changed DATETIME DEFAULT CURRENT_TIMESTAMP
);
