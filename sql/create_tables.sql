CREATE TABLE Person(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  name varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL
);

CREATE TABLE Class(
  name varchar(20) PRIMARY KEY NOT NULL
);

CREATE TABLE Chore(
  id SERIAL PRIMARY KEY,
  person_id INTEGER REFERENCES Person(id), -- Viiteavain Person-tauluun
  class_name varchar(20) REFERENCES Class(name),
  name varchar(50) NOT NULL,
  urgent boolean DEFAULT FALSE
);
