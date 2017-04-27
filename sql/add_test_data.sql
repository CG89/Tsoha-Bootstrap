-- Person-taulun testidata
INSERT INTO Person (name, password) VALUES ('Christian', 'chgr'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Person (name, password) VALUES ('Henri', 'Henri123');
-- Category taulun testidata
INSERT INTO Category (name, person_id) VALUES ('pyykit',1);
INSERT INTO Category (name, person_id) VALUES ('kauppa',2);
INSERT INTO Category (name, person_id) VALUES ('yleinen',1);
-- Chore taulun testidata
INSERT INTO Chore (name, person_id, urgent) VALUES ('Pyykit', 1, TRUE);
INSERT INTO Chore (name, person_id, urgent) VALUES ('Koirat aamulenkille',1,FALSE);
INSERT INTO Chore (name, person_id) VALUES ('Käy kaupassa',2);
--ChoreCategory taulun testidata
INSERT INTO ChoreCategory (chore_id, category_id) VALUES (1,1);
INSERT INTO ChoreCategory (chore_id, category_id) VALUES (3,2);
INSERT INTO ChoreCategory (chore_id, category_id) VALUES (2,3);
INSERT INTO ChoreCategory (chore_id, category_id) VALUES (1,3);
