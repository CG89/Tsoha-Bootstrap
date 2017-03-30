-- Person-taulun testidata
INSERT INTO Person (name, password) VALUES ('Christian', 'chgr'); -- Koska id-sarakkeen tietotyyppi on SERIAL, se asetetaan automaattisesti
INSERT INTO Person (name, password) VALUES ('Henri', 'Henri123');
-- Class taulun testidata
INSERT INTO Class (name) VALUES ('pyykit');
-- Chore taulun testidata
INSERT INTO Chore (name, person_id, urgent) VALUES ('Pyykit', 1, TRUE);
INSERT INTO Chore (name, person_id, urgent) VALUES ('Koirat aamulenkille',1,FALSE);
INSERT INTO Chore (name, person_id) VALUES ('Käy kaupassa',2);
