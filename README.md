01 xampp install in PC <br>
02 open to xampp <br>
03 start to Apache <br>
04 start to MySQL and Admin <br>
05 open to phpmyadmin <br>
06 click to SQL and past code and go creat to database <br>

CREATE DATABASE IF NOT EXISTS profile;

USE profile;

CREATE TABLE IF NOT EXISTS `data` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `Full_Name` VARCHAR(255) NOT NULL,
    `Contact_Number` VARCHAR(20) NOT NULL,
    `Email` VARCHAR(255) NOT NULL UNIQUE,
    `Gender` VARCHAR(10) NOT NULL,
    `Password` VARCHAR(255) NOT NULL,
    `DateTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
