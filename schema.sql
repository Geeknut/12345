CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title CHAR(128),
    symbolic_code CHAR(64)
);
INSERT INTO category
(title, symbolic_code) VALUES ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'), ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creation_date TIMESTAMP,
    title CHAR(128),
    description TEXT(500),
    img_url VARCHAR(2083),
    initial_price CHAR(64),
    end_date TIMESTAMP,
    step_rate CHAR(64),
    author_id CHAR(64),
    winner_id CHAR(64),
    cat_id CHAR(64)
);

CREATE TABLE rate (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rate_date TIMESTAMP,
    price CHAR(128),
    user_id CHAR(64),
    lot_id CHAR(64)

);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_date TIMESTAMP,
    e_mail VARCHAR(320),
    name CHAR(128),
    password CHAR(64),
    user_img VARCHAR(2083),
    contacts TEXT(500),
    lot_id CHAR(64),
    rate_id CHAR(64)

);