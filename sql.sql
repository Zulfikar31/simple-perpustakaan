CREATE DATABASE library;
CREATE TABLE pinjaman (id_buku int NOT null , id_user int NOT null);
CREATE TABLE buku (id_buku int NOT null primary key auto_increment, nama varchar(200) NOT null, deskripsi text NOT null);
CREATE TABLE user (id int NOT null primary key auto_increment, username VARCHAR(100) NOT null, password VARCHAR(250) NOT null);