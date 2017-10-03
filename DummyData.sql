INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `acctType`, `dateAdded`) VALUES ('1', 'Gene', 'Casey', 'admin', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', 'Admin', '2017-08-22');

INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `acctType`, `dateAdded`) VALUES ('2', 'Craig', 'Johnson', 'Craig', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', 'Standard User', '2017-08-22');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('1', '1', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('2', '2', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('3', '3', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('4', '4', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('5', '5', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('A', '1', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('B', '2', '1', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('C', '3', '0', '0');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('D', '4', '0', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`, `IsCheckoutable`, `IsConsumable`) VALUES ('E', '5', '0', '0');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (1, 'Bolt', '1', 'XU338026956', 'Joe Johnson', 'Nursing 162', 1, 5, 3, '2017-09-29', 'Tester');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (2, 'Screw', '2', 'YW425757483', 'Mary Sue', 'Checkout', 0, 1, 1, '2017-09-30', 'John');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (3, 'Nut', '3', 'ET474374601', 'Drew Hills', 'Nursing 161', 1, 4, 2, '2017-09-20', 'Tester');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (4, 'Wrench', 'A', 'CJ763287594', 'Joe Johnson', 'Nursing 162', 0, 5, 0, '2017-08-29', 'Frank');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (5, 'Hammer', 'B', 'IP472802749', 'Drew Hills', 'Checkout', 0, 2, 1, '2016-09-29', 'Bob');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`, `Last Processing Date`, `Last Processing Person`) VALUES (6, 'Nail', 'C', 'TM852187346', 'Mary Sue', 'Nursing 162', 1, 0, 0, '2012-02-22', 'Joe');

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (1, 'HP LaserJet 1012,1018,1022 Toner', 'D', 'Surplus', 4, 1);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (2, 'Sandisk Cruzer 16GB', 'E', 'Drawer', 10, 3);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (3, 'HP LaserJet P1102W', 'D', 'Surplus', 7, 2);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (4, 'Verbatim PinStrip USB Drive', 'E', 'Drawer', 1, 1);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (5, 'Staples 16GB Flash Drive', 'E', 'Drawer', 6, 0);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (6, 'HP P3005 Toner', 'D', 'Surplus', 4, 3);

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('1', 'Hughey', 'Douglas', '6733', 'hugheyd@umsl.edu', '164');

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('2', 'Bai', 'Mei', '6066', 'baimei@umsl.edu', '306 SC');

INSERT INTO `loginsystem`.`clients` (`Number`, `Last`, `First`, `Ext`, `Email`, `Office`) VALUES ('3', 'Reid', 'Roxanne', '8610', 'reidr@umsl.edu', '218 SC');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('1', 'Bolt', '1', '1', 'XU338026956', 'Douglas Hughey', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('2', 'Screw', '2', '1', 'YW425757483', 'Mei Bai', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('3', 'Nut', '3', '1', 'ET474374601', 'Roxanne Reid', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('4', 'Wrench', 'A', '1', 'CJ763287594', 'Douglas Hughey', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('5', 'Hammer', 'B', '1', 'IP472802749', 'Roxanne Reid', 'Project', 'Will return soon', '2017-12-31', '2017-10-03', 'admin');

INSERT INTO `loginsystem`.`checkouts` (`Id`, `Item`, `Subtype`, `Quantity Borrowed`, `Serial Number`, `Person`, `Reason`, `Notes`, `Due Date`, `Checkout Date`, `Update Person`) VALUES ('6', 'Nail', 'C', '1', 'TM852187346', 'Mei Bai', 'Temporary', 'Coming Back', '2017-12-31', '2017-10-03', 'admin');