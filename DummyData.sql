INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `acctType`, `dateAdded`) VALUES ('1', 'Gene', 'Casey', 'admin', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', 'Admin', '2017-08-22');

INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `acctType`, `dateAdded`) VALUES ('2', 'Craig', 'Johnson', 'Craig', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', 'Standard User', '2017-08-22');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Still Camera', 'Camera', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Apple', 'Software', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Brother 2000 Series', 'Printer', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Black Toner', 'Printer Cartridge', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Flash Drive', 'Storage Device', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Digital Camera', 'Camera', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Adobe', 'Software', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('HP Printer', 'Printer', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Color Toner', 'Printer Cartridge', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Staples Flash Drive', 'Storage Device', '0', '1');

INSERT INTO `loginsystem`.`inventory` (`Serial Number`, `Item`, `Subtype`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Last Processing Date`, `Last Processing Person`) VALUES ('XU338026956', 'Canon PowerShot A710 IS', 'Still Camera', 'Joe Johnson', 'Nursing 162', 1, 1, '2017-09-29', 'Tester');

INSERT INTO `loginsystem`.`inventory` (`Serial Number`, `Item`, `Subtype`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Last Processing Date`, `Last Processing Person`) VALUES ('ET474374601', 'Apple MAC OS X 10.4', 'Apple', 'Drew Hills', 'Nursing 161', 1, 1, '2017-09-20', 'Tester');

INSERT INTO `loginsystem`.`inventory` (`Serial Number`, `Item`, `Subtype`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Last Processing Date`, `Last Processing Person`) VALUES ('YW425757483', 'Brother HL-2270DW Printer', 'Brother 2000 Series', 'Mary Sue', 'Checkout', 0, 1, '2017-09-30', 'John');

INSERT INTO `loginsystem`.`inventory` (`Serial Number`, `Item`, `Subtype`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Last Processing Date`, `Last Processing Person`) VALUES ('CJ763287594', 'Canon Rebel EOS T5i', 'Digital Camera', 'Joe Johnson', 'Nursing 162', 0, 1, '2017-08-29', 'Frank');

INSERT INTO `loginsystem`.`inventory` (`Serial Number`, `Item`, `Subtype`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Last Processing Date`, `Last Processing Person`) VALUES ('IP472802749', 'Adobe PhotoShop CS', 'Adobe', 'Drew Hills', 'Checkout', 0, 1, '2016-09-29', 'Bob');

INSERT INTO `loginsystem`.`inventory` (`Serial Number`, `Item`, `Subtype`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Last Processing Date`, `Last Processing Person`) VALUES ('TM852187346', 'HP PhotoSmart D7560 Printer', 'HP Printer', 'Mary Sue', 'Nursing 162', 1, 0, '2012-02-22', 'Joe');

INSERT INTO `loginsystem`.`consumables`(`Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES ('HP LaserJet 1012,1018,1022 Toner', 'Black Toner', 'Surplus', 4, 1);

INSERT INTO `loginsystem`.`consumables`(`Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES ('Sandisk Cruzer 16GB', 'Flash Drive', 'Drawer', 10, 3);

INSERT INTO `loginsystem`.`consumables`(`Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES ('HP LaserJet P1102W', 'Black Toner', 'Surplus', 7, 2);

INSERT INTO `loginsystem`.`consumables`(`Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES ('Verbatim PinStrip USB Drive', 'Flash Drive', 'Drawer', 1, 1);

INSERT INTO `loginsystem`.`consumables`(`Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES ('Staples 16GB Flash Drive', 'Flash Drive', 'Drawer', 6, 0);

INSERT INTO `loginsystem`.`consumables`(`Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES ('HP P3005 Toner', 'Black Toner', 'Surplus', 4, 3);

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('1', 'Hughey', 'Douglas', '6733', 'hugheyd@umsl.edu', '164');

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('2', 'Bai', 'Mei', '6066', 'baimei@umsl.edu', '306 SC');

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('3', 'Reid', 'Roxanne', '8610', 'reidr@umsl.edu', '218 SC');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('1', 'Canon PowerShot A710 IS', 'Still Camera', '1', 'XU338026956', 'Douglas Hughey', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('2', 'Apple MAC OS X 10.4', 'Apple', '1', 'ET474374601', 'Mei Bai', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('6', 'HP PhotoSmart D7560 Printer', 'HP Printer', '1', 'TM852187346', 'Mei Bai', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`consumptions` (`Id`, `Item`, `Subtype`, `Quantity`, `Person`, `Reason`, `Consume Date`, `Update Person`) VALUES ('1', 'HP LaserJet 1012,1018,1022 Toner', 'Black Toner', '1', 'Douglas Hughey', 'Printer\'s out', '2017-10-10', 'admin');

INSERT INTO `loginsystem`.`consumptions` (`Id`, `Item`, `Subtype`, `Quantity`, `Person`, `Reason`, `Consume Date`, `Update Person`) VALUES ('2', 'Sandisk Cruzer 16GB', 'Flash Drive', '2', 'Mei Bai', 'Needed for storage', '2017-10-11', 'admin');

INSERT INTO `loginsystem`.`consumptions` (`Id`, `Item`, `Subtype`, `Quantity`, `Person`, `Reason`, `Consume Date`, `Update Person`) VALUES ('3', 'HP P3005 Toner', 'Black Toner', '1', 'Roxanne Reid', 'Printer\'s out', '2017-10-10', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('1', 'Add inventory', 'Canon PowerShot A710 IS', 'Still Camera', '5', '2017-10-10 10:06:10', 'Craig');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('2', 'Edit inventory', 'Apple MAC OS X 10.4', 'Apple', '4', '2017-10-11 12:36:16', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('3', 'Delete inventory', 'Brother HL-2270DW Printer', 'Brother 2000 Series', '3', '2017-10-10 15:05:00', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('4', 'Add consumable', 'HP LaserJet 1012,1018,1022 Toner', 'Black Toner', '5', '2017-10-10 08:51:32', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('5', 'Edit consumable', 'Verbatim PinStrip USB Drive', 'Flash Drive', '1', '2017-10-11 17:42:12', 'Craig');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('6', 'Delete consumable', 'Staples 16GB Flash Drive', 'Flash Drive', '1', '2017-10-11 13:14:16', 'admin');

INSERT INTO `loginsystem`.`repairs/updates/upgrades`(`Id`, `Type`, `Serial Number`, `Part`, `Cost`, `Date`, `Supplier`, `Reason`) VALUES ('1', 'Repair', 'XU338026956', 'Lens', '29.95', '2017-10-24', 'Canon', 'Replaces broken lens');

INSERT INTO `loginsystem`.`repairs/updates/upgrades`(`Id`, `Type`, `Serial Number`, `Part`, `Cost`, `Date`, `Supplier`, `Reason`) VALUES ('2', 'Update', 'IP472802749', 'Software', '99.99', '2017-10-25', 'Adobe', 'Annual major update');

INSERT INTO `loginsystem`.`repairs/updates/upgrades`(`Id`, `Type`, `Serial Number`, `Part`, `Cost`, `Date`, `Supplier`, `Reason`) VALUES ('3', 'Upgrade', 'YW425757483', 'Spooler', '19.99', '2017-10-20', 'Brother', 'Larger spooler');

INSERT INTO `loginsystem`.`serviceAgreements`(`Id`, `Name`, `Annual Cost`, `Duration`, `Expiration Date`) VALUES ('1', 'Windows Service', '499.99', '1 Year', '2018-10-20');

INSERT INTO `loginsystem`.`serviceAgreements`(`Id`, `Name`, `Annual Cost`, `Duration`, `Expiration Date`) VALUES ('2', 'Antivirus Service', '99.99', '1 Year', '2018-02-17');

INSERT INTO `loginsystem`.`serviceAgreements`(`Id`, `Name`, `Annual Cost`, `Duration`, `Expiration Date`) VALUES ('3', 'Mac Service', '199.99', '1 Year', '2018-08-30');