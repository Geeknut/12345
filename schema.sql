CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(128) NOT NULL UNIQUE,
    code VARCHAR(64) UNIQUE
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(128) NOT NULL,
    description VARCHAR(500) NOT NULL,
    image VARCHAR(2083) NOT NULL,
    initial_price INT NOT NULL,
    end_time DATETIME NOT NULL,
    step_rate INT NOT NULL,
    user_id INT NOT NULL,
    winner_id INT NULL,
    category_id INT NOT NULL
);

CREATE INDEX create_time ON lot(create_time);
CREATE INDEX title ON lot(title);
CREATE INDEX user_id ON lot(user_id);
CREATE INDEX category_id ON lot(category_id);

CREATE TABLE rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    price INT NOT NULL,
    user_id INT NOT NULL,
    lot_id INT NOT NULL

);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY ,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(320) NOT NULL UNIQUE,
    name VARCHAR(128) NOT NULL,
    password VARCHAR(64) NOT NULL,
    avatar VARCHAR(2083) NULL,
    contacts VARCHAR(500) NOT NULL

);

CREATE INDEX create_time ON user(create_time);
CREATE INDEX name ON user(name);