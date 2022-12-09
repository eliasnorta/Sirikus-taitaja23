/* luo taulukon esitys */
CREATE TABLE `Esitys` (
  `esitysID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `teema` varchar(30) NOT NULL,
  `esityspaikka` varchar(15) NOT NULL,
  `kaupunki` varchar(20) NOT NULL,
  `pvm` date NOT NULL,
  `paikat` int(10) NOT NULL,
  `vapaitapaikkoja` int(10) NOT NULL
);

CREATE TABLE `Tilaaja` (
  `tilaajaID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sposti` varchar(30) NOT NULL,
  `puhelin` varchar(15) NOT NULL,
  `paikkojenlkm` int(20) NOT NULL,
  `esitysID` int(10) NOT NULL
);

/* tietojen lisäys tietokantaan */
INSERT INTO `esitys` 
    ( `teema`, `esityspaikka`, `kaupunki`, `pvm`, `paikat`, `vapaitapaikkoja`) 
VALUES
    ('Avaruuden valloittaminen', 'Kulttuurikeskus Caisa', 'Helsinki', '2023-1-18', 50, 40),
    ('Jooga', 'Louhisali', 'Tapiola', '2023-6-29', 291, 110);
