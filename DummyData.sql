INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `dateAdded`) VALUES ('1', 'Gene', 'Casey', 'admin', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', '2017-08-22');

INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`, `dateAdded`) VALUES ('2', 'Craig', 'Johnson', 'Craig', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO', '2017-08-22');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('1', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('2', '2');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('3', '3');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('4', '4');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('5', '5');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('A', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('B', '2');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('C', '3');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('D', '4');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('E', '5');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`) VALUES (1, 'Bolt', '1', 'XU338026956', 'Joe Johnson', 'Nursing 162', 1, 5, 3);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`) VALUES (2, 'Screw', '2', 'YW425757483', 'Mary Sue', 'Checkout', 0, 1, 1);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`) VALUES (3, 'Nut', '3', 'ET474374601', 'Drew Hills', 'Nursing 161', 1, 4, 2);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`) VALUES (4, 'Wrench', 'A', 'CJ763287594', 'Joe Johnson', 'Nursing 162', 0, 5, 0);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`) VALUES (5, 'Hammer', 'B', 'IP472802749', 'Drew Hills', 'Checkout', 0, 2, 1);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Serial Number`, `Assigned to`, `Location`, `Checkoutable`, `Number in Stock`, `Minimum Stock`) VALUES (6, 'Nail', 'C', 'TM852187346', 'Mary Sue', 'Nursing 162', 1, 0, 0);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (1, 'HP LaserJet 1012,1018,1022 Toner', 'D', 'Surplus', 4, 1);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (2, 'Sandisk Cruzer 16GB', 'E', 'Drawer', 10, 3);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (3, 'HP LaserJet P1102W', 'D', 'Surplus', 7, 2);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (4, 'Verbatim PinStrip USB Drive', 'E', 'Drawer', 1, 1);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (5, 'Staples 16GB Flash Drive', 'E', 'Drawer', 6, 0);

INSERT INTO `loginsystem`.`consumables`(`id`, `Item`, `Subtype`, `Location`, `Number in Stock`, `Minimum Stock`) VALUES (6, 'HP P3005 Toner', 'D', 'Surplus', 4, 3);