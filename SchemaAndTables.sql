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
  Subtype VARCHAR(100) NOT NULL,
  `Serial Number` VARCHAR(100), /*Different*/
  `Assigned to` VARCHAR(100) NOT NULL, /*Different*/
  Location VARCHAR(100) NOT NULL,
  `Number in Stock` INT NOT NULL,
  `Minimum Stock` INT,
  Checkoutable TINYINT(1) NOT NULL, /*Different*/
  PRIMARY KEY (inv_id));

CREATE TABLE loginsystem.consumables (
  id INT NOT NULL AUTO_INCREMENT,
  Item VARCHAR(100) NOT NULL,
  Subtype VARCHAR(100) NOT NULL,
  Location VARCHAR(100) NOT NULL,
  `Number in Stock` INT NOT NULL,
  `Minimum Stock` INT,
  PRIMARY KEY (id));

CREATE TABLE loginsystem.subtypes (
  Subtype VARCHAR(100) NOT NULL,
  Type VARCHAR(100) NOT NULL,
  PRIMARY KEY (Subtype));