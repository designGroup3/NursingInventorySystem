INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`) VALUES ('1', 'Michael', 'Lacy', 'admin', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO');

INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`) VALUES ('2', 'Craig', 'Johnson', 'Craig', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (1, 'Bolt', '1', 0, 1, 0);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (2, 'Screw', '2', 1, 0, 1);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (3, 'Nut', '3', 1, 1, 2);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (4, 'Wrench', 'A', 0, 0, 3);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (5, 'Hammer', 'B', 0, 1, 4);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (6, 'Nail', 'C', 1, 1, 5);

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('1', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('2', '2');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('3', '3');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('A', '1');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('B', '2');

INSERT INTO `loginsystem`.`subtypes` (`Subtype`, `Type`) VALUES ('C', '3');