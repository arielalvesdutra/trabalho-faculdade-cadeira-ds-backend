-- DATABASE HAS --
CREATE DATABASE IF NOT EXISTS `has` DEFAULT CHARACTER SET utf8 ;

USE has;

-- TABELA USERS --
CREATE TABLE IF NOT EXISTS users (
	id int(12) not null auto_increment,
    name VARCHAR(50) not null,
    email VARCHAR(50) not null unique,
    password VARCHAR(50) not null,
    primary key (id)    
)engine=InnoDb;

-- TABELA USER_PROFILES --
CREATE TABLE IF NOT EXISTS user_profiles(
	id int(4) not null auto_increment,
    name VARCHAR(50) not null,
    code VARCHAR(50) not null unique,
    primary key (id)
)engine=InnoDb;

-- TABELA USERS_USER_PROFILES --
CREATE TABLE IF NOT EXISTS users_user_profiles(
  id_user int (11) not null,
  id_user_profile int(11) not null,
  PRIMARY KEY (id_user, id_user_profile),
  FOREIGN KEY (id_user) REFERENCES users(id),
  FOREIGN KEY (id_user_profile) REFERENCES user_profiles(id)
)engine=InnoDB;

-- TABELA JUSTIFICATIONS --
CREATE TABLE IF NOT EXISTS justifications (
  id int(7) NOT NULL auto_increment,
  title varchar(60) NOT NULL UNIQUE,
  PRIMARY KEY (id)
)engine=InnoDB;

-- TABELA HOURS_ADJUSTMENTS --
CREATE TABLE IF NOT EXISTS hours_adjustments (
  id int(13) NOT NULL AUTO_INCREMENT,
  date varchar(10) NOT NULL,
  entryHour varchar(8) NOT NULL,
  exitHour varchar(8) NOT NULL,
  duration varchar(8) NOT NULL,
  id_justification int(8) NOT NULL,
  id_user int(12) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_justification) REFERENCES justifications(id),
  FOREIGN KEY (id_user) REFERENCES users(id)
)ENGINE=InnoDb;

-- TABELA HOURS_ADJUSTMENTS_STATUS --
CREATE TABLE IF NOT EXISTS hours_adjustments_status (
  id int(4) not null auto_increment,
  code varchar (50)  not null unique,
  name varchar (80),
  primary key (id)
)engine=InnoDB;

-- TABELA USERS_HOURS_ADJUSTMENTS_STATUS -- 
CREATE TABLE IF NOT EXISTS users_hours_adjustments_status (
  id_status int (4) not null,
  id_user int (12) not null,
  PRIMARY KEY (id_status, id_user),
  FOREIGN KEY (id_status) REFERENCES hours_adjustments_status(id),
  FOREIGN KEY (id_user) REFERENCES users(id)
)engine=InnoDb;
