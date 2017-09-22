CREATE SCHEMA loginsystem;

CREATE TABLE loginsystem.users (
  id INT NOT NULL AUTO_INCREMENT,
  first VARCHAR(128) NOT NULL,
  last VARCHAR(128) NOT NULL,
  uid VARCHAR(128) UNIQUE NOT NULL,
  pwd VARCHAR(1000) NOT NULL,
  dateAdded DATE NOT NULL,
  PRIMARY KEY (id));

CREATE TABLE loginsystem.subtypes (
  Subtype VARCHAR(100) NOT NULL,
  Type VARCHAR(100) NOT NULL,
  PRIMARY KEY (Subtype));

CREATE TABLE loginsystem.inventory (
  inv_id INT NOT NULL AUTO_INCREMENT,
  Item VARCHAR(100) NOT NULL,
  Subtype VARCHAR(100) NOT NULL,
  `Serial Number` VARCHAR(100),
  `Assigned to` VARCHAR(100) NOT NULL,
  Location VARCHAR(100) NOT NULL,
  Checkoutable TINYINT(1) NOT NULL,
  `Number in Stock` INT NOT NULL,
  `Minimum Stock` INT,
  PRIMARY KEY (inv_id),
  FOREIGN KEY (Subtype) REFERENCES subtypes(Subtype));

CREATE TABLE loginsystem.consumables (
  id INT NOT NULL AUTO_INCREMENT,
  Item VARCHAR(100) NOT NULL,
  Subtype VARCHAR(100) NOT NULL,
  Location VARCHAR(100) NOT NULL,
  `Number in Stock` INT NOT NULL,
  `Minimum Stock` INT,
  PRIMARY KEY (id),
  FOREIGN KEY (Subtype) REFERENCES subtypes(Subtype));