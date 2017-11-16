CREATE SCHEMA loginsystem;

CREATE TABLE loginsystem.users (
  id INT NOT NULL AUTO_INCREMENT,
  first VARCHAR(128) NOT NULL,
  last VARCHAR(128) NOT NULL,
  uid VARCHAR(128) UNIQUE NOT NULL,
  pwd VARCHAR(1000) NOT NULL,
  email VARCHAR(200) NOT NULL,
  acctType VARCHAR(20) NOT NULL,
  dateAdded DATE NOT NULL,
  pwdRecoveryKey VARCHAR(100),
  PRIMARY KEY (id));

CREATE TABLE loginsystem.subtypes (
  Subtype VARCHAR(100) NOT NULL,
  Type VARCHAR(100) NOT NULL,
  `Table` VARCHAR(15) NOT NULL,
  PRIMARY KEY (Subtype));

CREATE TABLE loginsystem.inventory (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Serial Number` VARCHAR(100),
  Item VARCHAR(100) NOT NULL,
  Subtype VARCHAR(100) NOT NULL,
  `Assigned to` VARCHAR(100) NOT NULL,
  Location VARCHAR(100) NOT NULL,
  Checkoutable TINYINT(1) NOT NULL,
  `Number in Stock` INT NOT NULL,
  `MAC Address` VARCHAR(100),
  `IP Address` VARCHAR(100),
  `Last Processing Date` DATE,
  `Last Processing Person` VARCHAR(100),
  PRIMARY KEY (`Id`));

CREATE TABLE loginsystem.consumables (
  Item VARCHAR(100) NOT NULL,
  Subtype VARCHAR(100) NOT NULL,
  Location VARCHAR(100) NOT NULL,
  `Number in Stock` INT NOT NULL,
  `Minimum Stock` INT,
  `Last Processing Date` DATE,
  `Last Processing Person` VARCHAR(100),
  PRIMARY KEY (Item));

CREATE TABLE `loginsystem`.`clients` (
  `Number` INT NOT NULL AUTO_INCREMENT,
  `Last` VARCHAR(100) NOT NULL,
  `First` VARCHAR(100) NOT NULL,
  `Ext` INT NOT NULL,
  `Email` VARCHAR(100) NOT NULL,
  `Office` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Number`));

CREATE TABLE `loginsystem`.`checkouts` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Item` VARCHAR(100) NOT NULL,
  `Subtype` VARCHAR(100) NOT NULL,
  `Quantity Borrowed` INT NOT NULL,
  `Serial Number` VARCHAR(100),
  `Person` VARCHAR(100) NOT NULL,
  `Reason` VARCHAR(500) NOT NULL,
  `Notes` VARCHAR(1000),
  `Due Date` DATE NOT NULL,
  `Checkout Date` DATE NOT NULL,
  `Return Date` DATE,
  `Update Person` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`));

CREATE TABLE `loginsystem`.`consumptions` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Item` VARCHAR(100) NOT NULL,
  `Subtype` VARCHAR(100) NOT NULL,
  `Quantity` INT NOT NULL,
  `Person` VARCHAR(100) NOT NULL,
  `Reason` VARCHAR(500) NOT NULL,
  `Consume Date` DATE NOT NULL,
  `Update Person` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`));

CREATE TABLE `loginsystem`.`reports` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Activity Type` VARCHAR(100) NOT NULL,
  `Item` VARCHAR(100) NOT NULL,
  `Subtype` VARCHAR(100) NOT NULL,
  `Quantity` INT NOT NULL,
  `Timestamp` VARCHAR(100) NOT NULL,
  `Update Person` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`));

CREATE TABLE `loginsystem`.`repairs/updates/upgrades` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Type` VARCHAR(10) NOT NULL,
  `Serial Number` VARCHAR(100) NOT NULL,
  `Part` VARCHAR(100) NOT NULL,
  `Cost` DECIMAL(8,2) NOT NULL,
  `Date` DATE NOT NULL,
  `Supplier` VARCHAR(100) NOT NULL,
  `Reason` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`));

CREATE TABLE `loginsystem`.`serviceAgreements` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `Annual Cost` DECIMAL(8,2) NOT NULL,
  `Duration` VARCHAR(100) NOT NULL,
  `Expiration Date` DATE NOT NULL,
  `Approval` VARCHAR(500),
  PRIMARY KEY (`Id`));