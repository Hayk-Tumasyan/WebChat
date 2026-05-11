CREATE DATABASE chat;

USE chat;

CREATE TABLE users(
    user_id INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    unique_id INT(255) UNIQUE,
    fname VARCHAR(255),
    lname VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    img VARCHAR(400),
    status BOOLEAN);
    
CREATE TABLE messages(
    msg_id INT(255) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    outgoing_msg_id INT(255),
    incoming_msg_id INT(255),
    msg TEXT,
    uploadedFile VARCHAR(255),
    sent_at INT(255));