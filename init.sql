DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS logins;
DROP TABLE IF EXISTS characters;
DROP TABLE IF EXISTS xplog;
DROP TABLE IF EXISTS skills;

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

CREATE TABLE skills (
    id int NOT NULL PRIMARY KEY,
    skill VARCHAR(255) NOT NULL,
    stype CHAR(1) NOT NULL,
    base BOOLEAN
);

INSERT INTO skills (id, skill, stype, base) VALUES
(10000, 'Athletik', 'A', 1),
(10100, 'Klettern', 'A', 0),
(10101, 'Hochgebirgsklettern', 'S', 0),
(10102, 'Fassadenklettern', 'S', 0),
(10103, 'Höhlenklettern', 'S', 0),
(10104, 'Freiklettern', 'S', 0),
(10105, 'Technisches Klettern', 'S', 0),
(10106, 'Höhenrettung', 'S', 0),
(10107, 'Bouldern', 'S', 0),
(10108, 'Parcour', 'S', 0),
(10109, 'Canyoning', 'S', 0),
(10200, 'Laufen', 'A', 0),
(10201, 'Sprinten', 'S', 0),
(10202, 'Langstreckenlauf', 'S', 0),
(10203, 'Marathonlauf', 'S', 0),
(10204, 'Joggen', 'S', 0),
(10205, 'Wandern', 'S', 0);

CREATE TABLE charskills (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    charid int NOT NULL,
    skillid int NOT NULL,
    stype char(1) NOT NULL,
    lvl INT NOT NULL DEFAULT 0
);