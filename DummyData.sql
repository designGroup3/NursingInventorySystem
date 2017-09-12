INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`) VALUES ('1', 'Michael', 'Lacy', 'admin', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO');

INSERT INTO `loginsystem`.`users` (`id`, `first`, `last`, `uid`, `pwd`) VALUES ('2', 'Craig', 'Johnson', 'Craig', '$2y$10$ECRibQRLCdD6Z/Ra2dq9y.lI78N2XZWesA6kjcXsm3peLZ.Ydq.lO');

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Type`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (1, 'Bolt', 'Fake', 'Bogus', 0, 1, 0);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Type`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (2, 'Screw', 'Not', 'Real', 0, 1, 0);

INSERT INTO `loginsystem`.`inventory` (`inv_id`, `Item`, `Type`, `Subtype`, `Consumable`, `Checkoutable`, `Number in Stock (Minimum)`) VALUES (3, 'Nut', 'Dummy', 'Data', 0, 1, 0);

INSERT INTO `loginsystem`.`types` (`Type`, `Subtype`) VALUES ('Fake', 'Bogus');

INSERT INTO `loginsystem`.`types` (`Type`, `Subtype`) VALUES ('Not', 'Real');

INSERT INTO `loginsystem`.`types` (`Type`, `Subtype`) VALUES ('Dummy', 'Data');