-- Person-taulun testidata
INSERT INTO Person (name, password) VALUES ('Christian', 'chgr'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Person (name, password) VALUES ('Henri', 'Henri123');
-- Category taulun testidata
INSERT INTO Category (name, person_id) VALUES ('pyykit',1);
-- Chore taulun testidata
INSERT INTO Chore (name, person_id, urgent) VALUES ('Pyykit', 1, TRUE);
INSERT INTO Chore (name, person_id, urgent) VALUES ('Koirat aamulenkille',1,FALSE);
INSERT INTO Chore (name, person_id) VALUES ('Käy kaupassa',2);
