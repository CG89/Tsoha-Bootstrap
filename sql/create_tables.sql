CREATE TABLE Person(
  id SERIAL PRIMARY KEY, -- SERIAL tyyppinen pääavain pitää huolen, että tauluun lisätyllä rivillä on aina uniikki pääavain. Kätevää!
  name varchar(50) NOT NULL, -- Muista erottaa sarakkeiden määrittelyt pilkulla!
  password varchar(50) NOT NULL
);

CREATE TABLE Category(
  id SERIAL PRIMARY KEY,
  person_id INTEGER REFERENCES Person(id),
  name varchar(20) NOT NULL
  
);

CREATE TABLE Chore(
  id SERIAL PRIMARY KEY,
  person_id INTEGER REFERENCES Person(id), -- Viiteavain Person-tauluun
  name varchar(50) NOT NULL,
  urgent boolean DEFAULT FALSE
);

CREATE TABLE ChoreCategory(
  chore_id INTEGER REFERENCES Chore(id),
  category_id INTEGER REFERENCES Category(id)
);
  
