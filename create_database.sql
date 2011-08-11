DROP DATABASE IF EXISTS mydatabase;

CREATE DATABASE mydatabase;

USE mydatabase;

DROP TABLE IF EXISTS writers;

CREATE TABLE writers (
  id          int PRIMARY KEY auto_increment,
  username    varchar(16) NOT NULL,
  password    varchar(64) NOT NULL
);

DROP TABLE IF EXISTS articles;

CREATE TABLE articles (
  id          int PRIMARY KEY auto_increment,
  id_writer   int NOT NULL,		# FOREIGN KEY writers.id
  id_category int NOT NULL,		# FOREIGN KEY category.id
  title       text NOT NULL,
  art_text    text NOT NULL,
  priority    int NOT NULL,
  created     int,
  modified    int,
  published   int
);

DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
  id          int PRIMARY KEY auto_increment,
  name        varchar(32) NOT NULL,
  description text,
  priority    int NOT NULL
);

DROP TABLE IF EXISTS pictures;

CREATE TABLE pictures (
  id          int PRIMARY KEY auto_increment,
  id_article  int NOT NULL,            # FOREIGN KEY articles.id
  priority    int NOT NULL,
  path		  text,
  title		  text
);

insert into writers (username, password)
             values ('foo', password('bar'));
             
insert into categories (name, description, priority)
             values ('Homepage', 'This is the Homepage', 1);