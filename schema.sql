CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(128) NOT NULL UNIQUE,
    symbolic_code VARCHAR(64) UNIQUE
);
INSERT INTO category
(title, symbolic_code) VALUES ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'), ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(128) NOT NULL,
    description TEXT(500) NOT NULL,
    image VARCHAR(2083) NOT NULL,
    initial_price INT NOT NULL,
    end_time DATETIME NOT NULL,
    step_rate INT NOT NULL,
    author_id INT NOT NULL,
    winner_id INT NOT NULL,
    category_id INT NOT NULL
);

CREATE TABLE rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rate_date TIMESTAMP NOT NULL,
    price INT NOT NULL,
    user_id INT NOT NULL,
    lot_id INT NOT NULL

);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_date TIMESTAMP NOT NULL,
    e_mail VARCHAR(320) NOT NULL UNIQUE,
    name VARCHAR(128) NOT NULL,
    password VARCHAR(64) NOT NULL,
    user_img VARCHAR(2083) NULL,
    contacts TEXT(500) NOT NULL

);