DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS logins;

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