CREATE SCHEMA loginsystem;

CREATE TABLE loginsystem.users (
  id INT NOT NULL AUTO_INCREMENT,
  first VARCHAR(128) NOT NULL,
  last VARCHAR(128) NOT NULL,
  uid VARCHAR(128) UNIQUE NOT NULL,
  pwd VARCHAR(1000) NOT NULL,
  PRIMARY KEY (id));

CREATE TABLE loginsystem.inventory (
  inv_id INT NOT NULL AUTO_INCREMENT,
  Item VARCHAR(100) NOT NULL,
  Type VARCHAR(100) NOT NULL,
  Consumable TINYINT(1) NOT NULL,
  Checkoutable TINYINT(1) NOT NULL,
  `Number in Stock (Minimum)` INT NOT NULL,
  PRIMARY KEY (inv_id));

CREATE TABLE loginsystem.types (
  Type VARCHAR(100) NOT NULL,
  Subtype VARCHAR(100) NOT NULL,
  PRIMARY KEY (Type));