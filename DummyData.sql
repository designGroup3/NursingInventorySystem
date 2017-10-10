INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `acctType`, `dateAdded`) VALUES ('1', 'Gene', 'Casey', 'admin', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', 'Admin', '2017-08-22');

INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `acctType`, `dateAdded`) VALUES ('2', 'Craig', 'Johnson', 'Craig', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', 'Standard User', '2017-08-22');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Still Camera', 'Camera', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Apple', 'Software', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Brother 2000 Series', 'Printer', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Black Toner', 'Printer Cartridge', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Flash Drive', 'Storage Device', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Digital Camera', 'Camera', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Adobe', 'Software', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('HP Printer', 'Printer', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Color Toner', 'Printer Cartridge', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('Staples Flash Drive', 'Storage Device', '0', '0');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (1, 'Canon PowerShot A710 IS', 'Still Camera', 'XU338026956', 'Joe Johnson', 'Nursing 162', 1, 5, 3, '2017-09-29', 'Tester');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (2, 'Apple MAC OS X 10.4', 'Apple', 'ET474374601', 'Drew Hills', 'Nursing 161', 1, 4, 2, '2017-09-20', 'Tester');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (3, 'Brother HL-2270DW Printer', 'Brother 2000 Series', 'YW425757483', 'Mary Sue', 'Checkout', 0, 1, 1, '2017-09-30', 'John');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (4, 'Canon Rebel EOS T5i', 'Digital Camera', 'CJ763287594', 'Joe Johnson', 'Nursing 162', 0, 5, 0, '2017-08-29', 'Frank');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (5, 'Adobe PhotoShop CS', 'Adobe', 'IP472802749', 'Drew Hills', 'Checkout', 0, 2, 1, '2016-09-29', 'Bob');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (6, 'HP PhotoSmart D7560 Printer', 'HP Printer', 'TM852187346', 'Mary Sue', 'Nursing 162', 1, 0, 0, '2012-02-22', 'Joe');

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (1, 'HP LaserJet 1012,1018,1022 Toner', 'Black Toner', 'Surplus', 4, 1);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (2, 'Sandisk Cruzer 16GB', 'Flash Drive', 'Drawer', 10, 3);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (3, 'HP LaserJet P1102W', 'Black Toner', 'Surplus', 7, 2);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (4, 'Verbatim PinStrip USB Drive', 'Flash Drive', 'Drawer', 1, 1);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (5, 'Staples 16GB Flash Drive', 'Flash Drive', 'Drawer', 6, 0);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (6, 'HP P3005 Toner', 'Black Toner', 'Surplus', 4, 3);

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('1', 'Hughey', 'Douglas', '6733', 'hugheyd@umsl.edu', '164');

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('2', 'Bai', 'Mei', '6066', 'baimei@umsl.edu', '306 SC');

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('3', 'Reid', 'Roxanne', '8610', 'reidr@umsl.edu', '218 SC');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('1', 'Canon PowerShot A710 IS', 'Still Camera', '1', 'XU338026956', 'Douglas Hughey', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('2', 'Apple MAC OS X 10.4', 'Apple', '1', 'YW425757483', 'Mei Bai', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('3', 'Brother HL-2270DW Printer', 'Brother 2000 Series', '1', 'ET474374601', 'Roxanne Reid', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('4', 'Canon Rebel EOS T5i', 'Digital Camera', '1', 'CJ763287594', 'Douglas Hughey', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('5', 'Adobe PhotoShop CS', 'Adobe', '1', 'IP472802749', 'Roxanne Reid', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('6', 'HP PhotoSmart D7560 Printer', 'HP Printer', '1', 'TM852187346', 'Mei Bai', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('1', 'Add inventory', '0', 'Canon PowerShot A710 IS', 'Still Camera', '5', '2017-10-10 10:06:10', 'Craig');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('2', 'Edit inventory', '0', 'Apple MAC OS X 10.4', 'Apple', '4', '2017-10-11 12:36:16', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('3', 'Delete inventory', '0', 'Brother HL-2270DW Printer', 'Brother 2000 Series', '3', '2017-10-10 15:05:00', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('4', 'Add consumable', '1', 'HP LaserJet 1012,1018,1022 Toner', 'Black Toner', '5', '2017-10-10 08:51:32', 'admin');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('5', 'Edit consumable', '1', 'Verbatim PinStrip USB Drive', 'Flash Drive', '1', '2017-10-11 17:42:12', 'Craig');

INSERT INTO `loginsystem`.`reports` (`Id`, `Activity Type`, `IsConsumable`, `Item`, `Subtype`, `Quantity`, `Timestamp`, `Update Person`) VALUES ('6', 'Delete consumable', '1', 'Staples 16GB Flash Drive', 'Flash Drive', '1', '2017-10-11 13:14:16', 'admin');