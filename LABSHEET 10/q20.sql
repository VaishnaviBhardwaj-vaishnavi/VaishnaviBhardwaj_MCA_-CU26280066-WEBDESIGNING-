CREATE DATABASE myproject_db;

CREATE USER 'myproject_user'@'localhost'
IDENTIFIED BY 'StrongPassword123!';

GRANT SELECT, INSERT, UPDATE, DELETE
ON myproject_db.*
TO 'myproject_user'@'localhost';

FLUSH PRIVILEGES;

USE myproject_db;

CREATE TABLE products (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,

    price DECIMAL(10,2) NOT NULL

);

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(190) UNIQUE NOT NULL,

    password_hash VARCHAR(255) NOT NULL,

    reset_token_hash CHAR(64) NULL,

    reset_expires_at DATETIME NULL

);
