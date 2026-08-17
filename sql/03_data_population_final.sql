/* =========================================================
   COMP 353 - MAIN PROJECT
   Country Soccer Club System (CSCS)
   Representative Data Population
   ========================================================= */


/* =========================================================
   Population
   ========================================================= */

INSERT INTO Population
(id, firstName, lastName, birthDate, SSN, medicareNo,
 phoneNumber, address, city, province, postalCode, email, gender)
VALUES
(5001, 'Jean', 'Tremblay', '1980-05-12',
 '950000001', 'DEM5001MED01',
 '514-555-1111', '123 Rue Guy',
 'Montreal', 'QC', 'H3H 2M1',
 'jtremblay@cscs.ca', 'M'),

(5002, 'Marc', 'Lavoie', '1985-11-20',
 '950000002', 'DEM5002MED02',
 '450-555-2222', '456 Rue Chomedey',
 'Laval', 'QC', 'H7V 2X3',
 'mlavoie@cscs.ca', 'M'),

(5003, 'Pierre', 'Gagnon', '1978-03-15',
 '950000003', 'DEM5003MED03',
 '514-555-3333', '100 Rue Peel',
 'Montreal', 'QC', 'H3B 2T9',
 'pgagnon@gmail.com', 'M'),

(5004, 'Lucas', 'Gagnon', '2012-06-10',
 '950000004', 'DEM5004MED04',
 '514-555-3333', '100 Rue Peel',
 'Montreal', 'QC', 'H3B 2T9',
 'lucas@gmail.com', 'M'),

(5005, 'Sophie', 'Gagnon', '2014-09-22',
 '950000005', 'DEM5005MED05',
 '514-555-3333', '100 Rue Peel',
 'Montreal', 'QC', 'H3B 2T9',
 'sophie@gmail.com', 'F'),

(5006, 'Alex', 'Roy', '2000-01-15',
 '950000006', 'DEM5006MED06',
 '514-555-4444', '200 Rue Ste-Cath',
 'Montreal', 'QC', 'H3B 1A1',
 'alex.roy@gmail.com', 'M'),

(5007, 'Gabriel', 'Lavoie', '2011-03-12',
 '950000007', 'DEM5007MED07',
 '514-555-7777', '12 Rue St-Denis',
 'Montreal', 'QC', 'H2X 3K8',
 'gabriel@gmail.com', 'M'),

(5008, 'Antoine', 'Cote', '2010-08-19',
 '950000008', 'DEM5008MED08',
 '514-555-8888', '45 St-Urbain',
 'Montreal', 'QC', 'H2W 1V1',
 'antoine@gmail.com', 'M'),

(5009, 'Mathieu', 'Bouchard', '2012-01-05',
 '950000009', 'DEM5009MED09',
 '514-555-9999', '88 Sherbrooke E',
 'Montreal', 'QC', 'H2X 1C2',
 'mathieu@gmail.com', 'M'),

(5010, 'Felix', 'Fortin', '2013-11-30',
 '950000010', 'DEM5010MED10',
 '514-555-0000', '101 Mont-Royal',
 'Montreal', 'QC', 'H2T 1N8',
 'felix@gmail.com', 'M'),

(5011, 'Isabelle', 'Moreau', '1982-04-10',
 '950000011', 'DEM5011MED11',
 '514-555-6666', '12 Rue Peel',
 'Montreal', 'QC', 'H3B 2T9',
 'imoreau@cscs.ca', 'F'),

(5012, 'Luc', 'Bernier', '1979-09-18',
 '950000012', 'DEM5012MED12',
 '450-555-7777', '88 Blvd Laval',
 'Laval', 'QC', 'H7T 1A1',
 'lbernier@cscs.ca', 'M'),

(5013, 'Chantal', 'Ducharme', '1988-12-05',
 '950000013', 'DEM5013MED13',
 '514-555-8888', '50 Ave Laurier',
 'Montreal', 'QC', 'H2T 1N8',
 'cducharme@cscs.ca', 'F'),

(5014, 'David', 'Lavoie', '2011-05-10',
 '950000014', 'DEM5014MED14',
 '450-555-1111', '123 Blvd Laval',
 'Laval', 'QC', 'H7T 1A1',
 'david@gmail.com', 'M'),

(5015, 'Nicolas', 'Roy', '2010-02-14',
 '950000015', 'DEM5015MED15',
 '450-555-2222', '456 Blvd Laval',
 'Laval', 'QC', 'H7T 1A1',
 'nicolas@gmail.com', 'M'),

(5016, 'Olivier', 'Gagnon', '2012-07-20',
 '950000016', 'DEM5016MED16',
 '450-555-3333', '789 Blvd Laval',
 'Laval', 'QC', 'H7T 1A1',
 'olivier@gmail.com', 'M'),

(5101, 'Adam', 'Martin', '2002-02-10',
 '951000001', 'QRY5101MED01',
 '514-555-6101', '1 Query St',
 'Montreal', 'QC', 'H3A 1A1',
 'adam.martin@example.com', 'M'),

(5102, 'Bruno', 'Pelletier', '2003-03-11',
 '951000002', 'QRY5102MED02',
 '514-555-6102', '2 Query St',
 'Montreal', 'QC', 'H3A 1A2',
 'bruno.pelletier@example.com', 'M'),

(5103, 'Charles', 'Nguyen', '2004-04-12',
 '951000003', 'QRY5103MED03',
 '514-555-6103', '3 Query St',
 'Montreal', 'QC', 'H3A 1A3',
 'charles.nguyen@example.com', 'M'),

(5104, 'Daniel', 'Smith', '2005-05-13',
 '951000004', 'QRY5104MED04',
 '514-555-6104', '4 Query St',
 'Montreal', 'QC', 'H3A 1A4',
 'daniel.smith@example.com', 'M'),

(5105, 'Ethan', 'Wilson', '2006-06-14',
 '951000005', 'QRY5105MED05',
 '514-555-6105', '5 Query St',
 'Montreal', 'QC', 'H3A 1A5',
 'ethan.wilson@example.com', 'M'),

(5106, 'Noah', 'Brown', '1997-01-15',
 '951000006', 'QRY5106MED06',
 '450-555-6106', '6 Query Ave',
 'Laval', 'QC', 'H7A 1A6',
 'noah.brown@example.com', 'M'),

(5107, 'Liam', 'Davis', '1998-02-16',
 '951000007', 'QRY5107MED07',
 '450-555-6107', '7 Query Ave',
 'Laval', 'QC', 'H7A 1A7',
 'liam.davis@example.com', 'M'),

(5108, 'Mason', 'Taylor', '1999-03-17',
 '951000008', 'QRY5108MED08',
 '450-555-6108', '8 Query Ave',
 'Laval', 'QC', 'H7A 1A8',
 'mason.taylor@example.com', 'M'),

(5109, 'Logan', 'Clark', '2000-04-18',
 '951000009', 'QRY5109MED09',
 '450-555-6109', '9 Query Ave',
 'Laval', 'QC', 'H7A 1A9',
 'logan.clark@example.com', 'M'),

(5110, 'Jacob', 'Lewis', '2001-05-19',
 '951000010', 'QRY5110MED10',
 '450-555-6110', '10 Query Ave',
 'Laval', 'QC', 'H7A 1B0',
 'jacob.lewis@example.com', 'M'),

(5111, 'Leo', 'Roy', '2010-01-20',
 '951000011', 'QRY5111MED11',
 '514-555-6111', '11 Keeper St',
 'Montreal', 'QC', 'H3B 2A1',
 'leo.roy@example.com', 'M'),

(5112, 'Hugo', 'Caron', '2010-02-21',
 '951000012', 'QRY5112MED12',
 '514-555-6112', '12 Keeper St',
 'Montreal', 'QC', 'H3B 2A2',
 'hugo.caron@example.com', 'M'),

(5113, 'Milan', 'Blais', '2011-03-22',
 '951000013', 'QRY5113MED13',
 '514-555-6113', '13 Keeper St',
 'Montreal', 'QC', 'H3B 2A3',
 'milan.blais@example.com', 'M'),

(5114, 'Theo', 'Girard', '2011-04-23',
 '951000014', 'QRY5114MED14',
 '514-555-6114', '14 Keeper St',
 'Montreal', 'QC', 'H3B 2A4',
 'theo.girard@example.com', 'M'),

(5115, 'Eli', 'Morin', '2012-05-24',
 '951000015', 'QRY5115MED15',
 '514-555-6115', '15 Keeper St',
 'Montreal', 'QC', 'H3B 2A5',
 'eli.morin@example.com', 'M'),

(5121, 'Andre', 'Roy', '1978-01-11',
 '951000021', 'QRY5121MED21',
 '514-555-6121', '21 Coach St',
 'Montreal', 'QC', 'H3C 3A1',
 'andre.roy@example.com', 'M'),

(5122, 'Marie', 'Caron', '1980-02-12',
 '951000022', 'QRY5122MED22',
 '514-555-6122', '22 Coach St',
 'Montreal', 'QC', 'H3C 3A2',
 'marie.caron@example.com', 'F'),

(5123, 'Paul', 'Blais', '1979-03-13',
 '951000023', 'QRY5123MED23',
 '514-555-6123', '23 Coach St',
 'Montreal', 'QC', 'H3C 3A3',
 'paul.blais@example.com', 'M'),

(5124, 'Julie', 'Girard', '1981-04-14',
 '951000024', 'QRY5124MED24',
 '514-555-6124', '24 Coach St',
 'Montreal', 'QC', 'H3C 3A4',
 'julie.girard@example.com', 'F'),

(5125, 'Louis', 'Morin', '1982-05-15',
 '951000025', 'QRY5125MED25',
 '514-555-6125', '25 Coach St',
 'Montreal', 'QC', 'H3C 3A5',
 'louis.morin@example.com', 'M'),

(5126, 'Robert', 'King', '1977-06-16',
 '951000026', 'QRY5126MED26',
 '450-555-6126', '26 Coach Ave',
 'Laval', 'QC', 'H7B 3A6',
 'robert.king@example.com', 'M'),

(6011, 'Martin', 'Leblanc', '1975-01-10',
 '960000011', 'MGR6011MED11',
 '514-555-7011', '11 Manager St',
 'Montreal', 'QC', 'H4A 2A1',
 'martin.leblanc@example.com', 'M'),

(6012, 'Sarah', 'Fortier', '1976-02-11',
 '960000012', 'MGR6012MED12',
 '514-555-7012', '12 Manager St',
 'Montreal', 'QC', 'H1A 2A2',
 'sarah.fortier@example.com', 'F'),

(6013, 'Eric', 'Landry', '1977-03-12',
 '960000013', 'MGR6013MED13',
 '450-555-7013', '13 Manager St',
 'Laval', 'QC', 'H7G 2A3',
 'eric.landry@example.com', 'M'),

(6014, 'Nathalie', 'Poirier', '1978-04-13',
 '960000014', 'MGR6014MED14',
 '450-555-7014', '14 Manager St',
 'Longueuil', 'QC', 'J4H 2A4',
 'nathalie.poirier@example.com', 'F'),

(6015, 'Patrick', 'Beaulieu', '1979-05-14',
 '960000015', 'MGR6015MED15',
 '514-555-7015', '15 Manager St',
 'Pointe-Claire', 'QC', 'H9R 2A5',
 'patrick.beaulieu@example.com', 'M'),

(6051, 'Simon', 'Gauthier', '1980-06-15',
 '960000051', 'COA6051MED51',
 '514-555-7051', '51 Coach St',
 'Montreal', 'QC', 'H4A 3A1',
 'simon.gauthier@example.com', 'M'),

(6052, 'Thomas', 'Bergeron', '1981-07-16',
 '960000052', 'COA6052MED52',
 '514-555-7052', '52 Coach St',
 'Montreal', 'QC', 'H1A 3A2',
 'thomas.bergeron@example.com', 'M'),

(6053, 'Kevin', 'Leduc', '1982-08-17',
 '960000053', 'COA6053MED53',
 '450-555-7053', '53 Coach St',
 'Laval', 'QC', 'H7G 3A3',
 'kevin.leduc@example.com', 'M'),

(6054, 'Samuel', 'Fontaine', '1983-09-18',
 '960000054', 'COA6054MED54',
 '450-555-7054', '54 Coach St',
 'Longueuil', 'QC', 'J4H 3A4',
 'samuel.fontaine@example.com', 'M'),

(6055, 'Vincent', 'Dion', '1984-10-19',
 '960000055', 'COA6055MED55',
 '514-555-7055', '55 Coach St',
 'Pointe-Claire', 'QC', 'H9R 3A5',
 'vincent.dion@example.com', 'M'),

(6101, 'Alice', 'Mercier', '1982-01-01',
 '961000001', 'FAM6101MED01',
 '514-555-7101', '101 Family St',
 'Montreal', 'QC', 'H4A 4A1',
 'alice.mercier@example.com', 'F'),

(6102, 'Brian', 'Tessier', '1981-02-02',
 '961000002', 'FAM6102MED02',
 '514-555-7102', '102 Family St',
 'Montreal', 'QC', 'H1A 4A2',
 'brian.tessier@example.com', 'M'),

(6103, 'Caroline', 'Dubois', '1983-03-03',
 '961000003', 'FAM6103MED03',
 '450-555-7103', '103 Family St',
 'Laval', 'QC', 'H7G 4A3',
 'caroline.dubois@example.com', 'F'),

(6104, 'Denis', 'Renaud', '1980-04-04',
 '961000004', 'FAM6104MED04',
 '450-555-7104', '104 Family St',
 'Longueuil', 'QC', 'J4H 4A4',
 'denis.renaud@example.com', 'M'),

(6105, 'Emma', 'Boucher', '1984-05-05',
 '961000005', 'FAM6105MED05',
 '514-555-7105', '105 Family St',
 'Pointe-Claire', 'QC', 'H9R 4A5',
 'emma.boucher@example.com', 'F'),

(6111, 'Alexis', 'Mercier', '2010-01-11',
 '961000011', 'MIN6111MED11',
 '514-555-7111', '111 Child St',
 'Montreal', 'QC', 'H4A 5A1',
 'alexis.mercier@example.com', 'M'),

(6112, 'Nathan', 'Mercier', '2012-02-12',
 '961000012', 'MIN6112MED12',
 '514-555-7112', '112 Child St',
 'Montreal', 'QC', 'H4A 5A2',
 'nathan.mercier@example.com', 'M'),

(6121, 'Felix', 'Tessier', '2010-03-13',
 '961000021', 'MIN6121MED21',
 '514-555-7121', '121 Child St',
 'Montreal', 'QC', 'H1A 5A1',
 'felix.tessier@example.com', 'M'),

(6122, 'Louis', 'Tessier', '2012-04-14',
 '961000022', 'MIN6122MED22',
 '514-555-7122', '122 Child St',
 'Montreal', 'QC', 'H1A 5A2',
 'louis.tessier@example.com', 'M'),

(6131, 'Mathis', 'Dubois', '2010-05-15',
 '961000031', 'MIN6131MED31',
 '450-555-7131', '131 Child St',
 'Laval', 'QC', 'H7G 5A1',
 'mathis.dubois@example.com', 'M'),

(6132, 'Raphael', 'Dubois', '2012-06-16',
 '961000032', 'MIN6132MED32',
 '450-555-7132', '132 Child St',
 'Laval', 'QC', 'H7G 5A2',
 'raphael.dubois@example.com', 'M'),

(6141, 'Owen', 'Renaud', '2010-07-17',
 '961000041', 'MIN6141MED41',
 '450-555-7141', '141 Child St',
 'Longueuil', 'QC', 'J4H 5A1',
 'owen.renaud@example.com', 'M'),

(6142, 'Logan', 'Renaud', '2012-08-18',
 '961000042', 'MIN6142MED42',
 '450-555-7142', '142 Child St',
 'Longueuil', 'QC', 'J4H 5A2',
 'logan.renaud2@example.com', 'M'),

(6151, 'Zachary', 'Boucher', '2010-09-19',
 '961000051', 'MIN6151MED51',
 '514-555-7151', '151 Child St',
 'Pointe-Claire', 'QC', 'H9R 5A1',
 'zachary.boucher@example.com', 'M'),

(6152, 'Emile', 'Boucher', '2012-10-20',
 '961000052', 'MIN6152MED52',
 '514-555-7152', '152 Child St',
 'Pointe-Claire', 'QC', 'H9R 5A2',
 'emile.boucher@example.com', 'M'),

(6301, 'Player', 'WestOne', '1998-01-01',
 '963000001', 'PLY6301MED01',
 '514-555-7301', '301 Player St',
 'Montreal', 'QC', 'H4A 6A1',
 'player6301@example.com', 'M'),

(6302, 'Player', 'WestTwo', '1997-02-02',
 '963000002', 'PLY6302MED02',
 '514-555-7302', '302 Player St',
 'Montreal', 'QC', 'H4A 6A2',
 'player6302@example.com', 'M'),

(6303, 'Player', 'EastOne', '1998-03-03',
 '963000003', 'PLY6303MED03',
 '514-555-7303', '303 Player St',
 'Montreal', 'QC', 'H1A 6A1',
 'player6303@example.com', 'M'),

(6304, 'Player', 'EastTwo', '1997-04-04',
 '963000004', 'PLY6304MED04',
 '514-555-7304', '304 Player St',
 'Montreal', 'QC', 'H1A 6A2',
 'player6304@example.com', 'M'),

(6305, 'Player', 'LavalOne', '1998-05-05',
 '963000005', 'PLY6305MED05',
 '450-555-7305', '305 Player St',
 'Laval', 'QC', 'H7G 6A1',
 'player6305@example.com', 'M'),

(6306, 'Player', 'LavalTwo', '1997-06-06',
 '963000006', 'PLY6306MED06',
 '450-555-7306', '306 Player St',
 'Laval', 'QC', 'H7G 6A2',
 'player6306@example.com', 'M'),

(6307, 'Player', 'SouthOne', '1998-07-07',
 '963000007', 'PLY6307MED07',
 '450-555-7307', '307 Player St',
 'Longueuil', 'QC', 'J4H 6A1',
 'player6307@example.com', 'M'),

(6308, 'Player', 'SouthTwo', '1997-08-08',
 '963000008', 'PLY6308MED08',
 '450-555-7308', '308 Player St',
 'Longueuil', 'QC', 'J4H 6A2',
 'player6308@example.com', 'M'),

(6309, 'Player', 'IslandOne', '1998-09-09',
 '963000009', 'PLY6309MED09',
 '514-555-7309', '309 Player St',
 'Pointe-Claire', 'QC', 'H9R 6A1',
 'player6309@example.com', 'M'),

(6310, 'Player', 'IslandTwo', '1997-10-10',
 '963000010', 'PLY6310MED10',
 '514-555-7310', '310 Player St',
 'Pointe-Claire', 'QC', 'H9R 6A2',
 'player6310@example.com', 'M');


/* =========================================================
   Locations
   ========================================================= */

INSERT INTO Locations
(id, type, name, address, city, province, postalCode,
 webAddress, maxCapacity)
VALUES
(5001, 'Head', 'Montreal Central',
 '1234 Sherbrooke St W', 'Montreal', 'QC',
 'H3G 1M8', 'www.cscs-mtl.ca', 500),

(5002, 'Branch', 'Laval North',
 '5678 Blvd Saint-Martin', 'Laval', 'QC',
 'H7T 1A1', 'www.cscs-laval.ca', 300),

(5101, 'Branch', 'Montreal Query Centre',
 '900 University St', 'Montreal', 'QC',
 'H3C 1K3', 'www.cscs-query-mtl.ca', 200),

(5102, 'Branch', 'Laval Query Centre',
 '700 Laval Blvd', 'Laval', 'QC',
 'H7N 1A1', 'www.cscs-query-laval.ca', 200),

(6001, 'Branch', 'CSCS West Montreal',
 '100 West St', 'Montreal', 'QC',
 'H4A 1A1', 'www.cscs-west.ca', 250),

(6002, 'Branch', 'CSCS East Montreal',
 '200 East St', 'Montreal', 'QC',
 'H1A 1A1', 'www.cscs-east.ca', 250),

(6003, 'Branch', 'CSCS North Laval',
 '300 North St', 'Laval', 'QC',
 'H7G 1A1', 'www.cscs-north.ca', 250),

(6004, 'Branch', 'CSCS South Shore',
 '400 South St', 'Longueuil', 'QC',
 'J4H 1A1', 'www.cscs-south.ca', 250),

(6005, 'Branch', 'CSCS West Island',
 '500 Island St', 'Pointe-Claire', 'QC',
 'H9R 1A1', 'www.cscs-island.ca', 250);


/* =========================================================
   Location Phone Numbers
   ========================================================= */

INSERT INTO LocationPhoneNumbers(locationId, phoneNumber)
VALUES
(5001, '514-555-0100'),
(5002, '450-555-0200'),

(5101, '514-555-5101'),
(5102, '450-555-5102'),

(6001, '514-555-6001'),
(6002, '514-555-6002'),
(6003, '450-555-6003'),
(6004, '450-555-6004'),
(6005, '514-555-6005');


/* =========================================================
   Personnel
   ========================================================= */

INSERT INTO Personnel(id)
VALUES
(5001),
(5002),
(5011),
(5012),
(5013),

(5121),
(5122),
(5123),
(5124),
(5125),
(5126),

(6011),
(6012),
(6013),
(6014),
(6015),

(6051),
(6052),
(6053),
(6054),
(6055);


/* =========================================================
   Personnel Operations
   ========================================================= */

INSERT INTO PersonnelOperations
(personnelId, locationId, startDate, endDate,
 role, title, mandate)
VALUES
(5001, 5001, '2022-01-01', NULL,
 'Administrator', 'General Manager', 'salaried'),

(5002, 5001, '2022-01-01', NULL,
 'Coach', 'Head Coach', 'salaried'),

(5011, 5002, '2022-01-01', NULL,
 'Administrator', 'Branch Manager', 'salaried'),

(5012, 5002, '2023-01-01', NULL,
 'Coach', 'Assistant Coach', 'volunteer'),

(5013, 5001, '2023-06-01', NULL,
 'Assistant Coach', 'Youth Coach', 'volunteer'),

(5121, 5101, '2024-01-01', NULL,
 'Coach', 'Head Coach', 'volunteer'),

(5122, 5101, '2024-01-01', NULL,
 'Coach', 'Head Coach', 'volunteer'),

(5123, 5101, '2024-01-01', NULL,
 'Coach', 'Head Coach', 'volunteer'),

(5124, 5101, '2024-01-01', NULL,
 'Coach', 'Head Coach', 'volunteer'),

(5125, 5101, '2024-01-01', NULL,
 'Coach', 'Head Coach', 'volunteer'),

(5126, 5102, '2024-01-01', NULL,
 'Coach', 'Head Coach', 'salaried'),

(6011, 6001, '2023-01-01', NULL,
 'Administrator', 'General Manager', 'salaried'),

(6012, 6002, '2023-01-01', NULL,
 'Administrator', 'General Manager', 'salaried'),

(6013, 6003, '2023-01-01', NULL,
 'Administrator', 'General Manager', 'salaried'),

(6014, 6004, '2023-01-01', NULL,
 'Administrator', 'General Manager', 'salaried'),

(6015, 6005, '2023-01-01', NULL,
 'Administrator', 'General Manager', 'salaried'),

(6051, 6001, '2023-01-01', NULL,
 'Coach', 'Head Coach', 'salaried'),

(6052, 6002, '2023-01-01', NULL,
 'Coach', 'Head Coach', 'salaried'),

(6053, 6003, '2023-01-01', NULL,
 'Coach', 'Head Coach', 'salaried'),

(6054, 6004, '2023-01-01', NULL,
 'Coach', 'Head Coach', 'salaried'),

(6055, 6005, '2023-01-01', NULL,
 'Coach', 'Head Coach', 'salaried');


/* =========================================================
   Club Members
   ========================================================= */

INSERT INTO ClubMembers(id, height, weight)
VALUES
(5004,145,40),
(5005,135,32),
(5006,180,75),
(5007,150,42),
(5008,155,46),
(5009,142,38),
(5010,138,35),
(5014,148,41),
(5015,152,44),
(5016,140,36),

(5101,180,76),
(5102,178,74),
(5103,181,77),
(5104,179,75),
(5105,182,78),

(5106,180,77),
(5107,177,73),
(5108,183,80),
(5109,176,72),
(5110,181,79),

(5111,160,50),
(5112,161,51),
(5113,158,48),
(5114,159,49),
(5115,157,47),

(6111,165,55),
(6112,155,45),
(6121,166,56),
(6122,156,46),
(6131,167,57),
(6132,157,47),
(6141,168,58),
(6142,158,48),
(6151,169,59),
(6152,159,49),

(6301,180,75),
(6302,182,78),
(6303,179,74),
(6304,181,77),
(6305,178,73),
(6306,183,79),
(6307,180,76),
(6308,182,78),
(6309,179,74),
(6310,181,77);


/* =========================================================
   Club Member Registrations
   ========================================================= */

INSERT INTO ClubMemberRegistrations
(memberId, locationId, startDate, endDate)
VALUES
(5004,5001,'2025-01-01',NULL),
(5005,5001,'2025-01-01',NULL),
(5006,5001,'2024-01-01',NULL),
(5007,5001,'2025-01-01',NULL),
(5008,5001,'2025-01-01',NULL),
(5009,5001,'2025-01-01',NULL),
(5010,5001,'2025-01-01',NULL),

(5014,5002,'2025-01-01',NULL),
(5015,5002,'2025-01-01',NULL),
(5016,5002,'2025-01-01',NULL),

(5101,5101,'2017-09-01',NULL),
(5102,5101,'2018-09-01',NULL),
(5103,5101,'2019-09-01',NULL),
(5104,5101,'2020-09-01',NULL),
(5105,5101,'2021-09-01',NULL),

(5106,5102,'2024-01-01',NULL),
(5107,5102,'2024-01-01',NULL),
(5108,5102,'2024-01-01',NULL),
(5109,5102,'2024-01-01',NULL),
(5110,5102,'2024-01-01',NULL),

(5111,5101,'2024-01-01',NULL),
(5112,5101,'2024-01-01',NULL),
(5113,5101,'2024-01-01',NULL),
(5114,5101,'2024-01-01',NULL),
(5115,5101,'2024-01-01',NULL),

(6111,6001,'2023-01-01',NULL),
(6112,6001,'2023-01-01',NULL),

(6121,6002,'2023-01-01',NULL),
(6122,6002,'2023-01-01',NULL),

(6131,6003,'2023-01-01',NULL),
(6132,6003,'2023-01-01',NULL),

(6141,6004,'2023-01-01',NULL),
(6142,6004,'2023-01-01',NULL),

(6151,6005,'2023-01-01',NULL),
(6152,6005,'2023-01-01',NULL),

(6301,6001,'2024-01-01',NULL),
(6302,6001,'2024-01-01',NULL),

(6303,6002,'2024-01-01',NULL),
(6304,6002,'2024-01-01',NULL),

(6305,6003,'2024-01-01',NULL),
(6306,6003,'2024-01-01',NULL),

(6307,6004,'2024-01-01',NULL),
(6308,6004,'2024-01-01',NULL),

(6309,6005,'2024-01-01',NULL),
(6310,6005,'2024-01-01',NULL);


/* =========================================================
   Hobby Types
   ========================================================= */

INSERT IGNORE INTO HobbyTypes(name)
VALUES
('Soccer'),
('Swimming'),
('Chess'),
('Gaming'),
('Running');


/* =========================================================
   Hobbies
   ========================================================= */

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5004,id
FROM HobbyTypes
WHERE name='Soccer';

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5004,id
FROM HobbyTypes
WHERE name='Chess';

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5005,id
FROM HobbyTypes
WHERE name='Swimming';

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5006,id
FROM HobbyTypes
WHERE name='Soccer';

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5006,id
FROM HobbyTypes
WHERE name='Running';

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5007,id
FROM HobbyTypes
WHERE name='Soccer';

INSERT IGNORE INTO Hobbies(memberId,hobbyId)
SELECT 5008,id
FROM HobbyTypes
WHERE name='Gaming';


/* =========================================================
   Family Members
   ========================================================= */

INSERT INTO FamilyMembers(childId,familyId,relationship)
VALUES
(5004,5003,'Father'),
(5005,5003,'Father'),

(5111,5121,'Father'),
(5112,5122,'Mother'),
(5113,5123,'Father'),
(5114,5124,'Mother'),
(5115,5125,'Father'),

(6111,6101,'Mother'),
(6112,6101,'Mother'),

(6121,6102,'Father'),
(6122,6102,'Father'),

(6131,6103,'Mother'),
(6132,6103,'Mother'),

(6141,6104,'Father'),
(6142,6104,'Father'),

(6151,6105,'Mother'),
(6152,6105,'Mother');


/* =========================================================
   Family Member Associations
   ========================================================= */

INSERT INTO FamilyMemberAssociations
(childId,familyId,startDate,endDate,relationship,familyType)
VALUES
(5004,5003,'2025-01-01',NULL,'Father','Primary'),
(5005,5003,'2025-01-01',NULL,'Father','Primary'),

(5111,5121,'2024-01-01',NULL,'Father','Primary'),
(5112,5122,'2024-01-01',NULL,'Mother','Primary'),
(5113,5123,'2024-01-01',NULL,'Father','Primary'),
(5114,5124,'2024-01-01',NULL,'Mother','Primary'),
(5115,5125,'2024-01-01',NULL,'Father','Primary'),

(6111,6101,'2023-01-01',NULL,'Mother','Primary'),
(6112,6101,'2023-01-01',NULL,'Mother','Primary'),

(6121,6102,'2023-01-01',NULL,'Father','Primary'),
(6122,6102,'2023-01-01',NULL,'Father','Primary'),

(6131,6103,'2023-01-01',NULL,'Mother','Primary'),
(6132,6103,'2023-01-01',NULL,'Mother','Primary'),

(6141,6104,'2023-01-01',NULL,'Father','Primary'),
(6142,6104,'2023-01-01',NULL,'Father','Primary'),

(6151,6105,'2023-01-01',NULL,'Mother','Primary'),
(6152,6105,'2023-01-01',NULL,'Mother','Primary');


/* =========================================================
   Family Member Location History
   ========================================================= */

INSERT INTO FamilyMemberLocations
(familyId,locationId,startDate,endDate)
VALUES
(5003,5001,'2025-01-01',NULL),

(5121,5101,'2024-01-01',NULL),
(5122,5101,'2024-01-01',NULL),
(5123,5101,'2024-01-01',NULL),
(5124,5101,'2024-01-01',NULL),
(5125,5101,'2024-01-01',NULL),

(6101,6001,'2023-01-01',NULL),
(6102,6002,'2023-01-01',NULL),
(6103,6003,'2023-01-01',NULL),
(6104,6004,'2023-01-01',NULL),
(6105,6005,'2023-01-01',NULL);


/* =========================================================
   Payments
   ========================================================= */

INSERT INTO Payments
(paymentId,memberId,date,amount,method,dueDate)
VALUES
(5001,5004,'2026-01-10 10:00:00',
 100.00,'credit','2026-01-15 00:00:00'),

(5002,5005,'2026-01-10 10:30:00',
 100.00,'debit','2026-01-15 00:00:00'),

(5003,5006,'2026-01-12 14:15:00',
 200.00,'credit','2026-01-15 00:00:00'),

(5004,5007,'2026-01-14 09:00:00',
 100.00,'cash','2026-01-15 00:00:00'),

(5005,5008,'2026-01-15 11:45:00',
 100.00,'debit','2026-01-15 00:00:00'),

(5101,5101,'2025-01-05 10:00:00',
 200.00,'credit','2025-01-01 00:00:00'),

(5102,5102,'2025-01-05 10:05:00',
 200.00,'credit','2025-01-01 00:00:00'),

(5103,5103,'2025-01-05 10:10:00',
 200.00,'credit','2025-01-01 00:00:00'),

(5104,5104,'2025-01-05 10:15:00',
 200.00,'credit','2025-01-01 00:00:00'),

(5105,5105,'2025-01-05 10:20:00',
 200.00,'credit','2025-01-01 00:00:00'),

(5106,5106,'2025-01-06 10:00:00',
 200.00,'debit','2025-01-01 00:00:00'),

(5107,5107,'2025-01-06 10:05:00',
 200.00,'debit','2025-01-01 00:00:00'),

(5108,5108,'2025-01-06 10:10:00',
 200.00,'debit','2025-01-01 00:00:00'),

(5109,5109,'2025-01-06 10:15:00',
 200.00,'debit','2025-01-01 00:00:00'),

(5110,5110,'2025-01-06 10:20:00',
 200.00,'debit','2025-01-01 00:00:00'),

(5111,5111,'2025-01-07 10:00:00',
 100.00,'cash','2025-01-01 00:00:00'),

(5112,5112,'2025-01-07 10:05:00',
 100.00,'cash','2025-01-01 00:00:00'),

(5113,5113,'2025-01-07 10:10:00',
 100.00,'cash','2025-01-01 00:00:00'),

(5114,5114,'2025-01-07 10:15:00',
 100.00,'cash','2025-01-01 00:00:00'),

(5115,5115,'2025-01-07 10:20:00',
 100.00,'cash','2025-01-01 00:00:00'),

(6111,6111,'2025-01-10 09:00:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6112,6112,'2025-01-10 09:05:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6121,6121,'2025-01-10 09:10:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6122,6122,'2025-01-10 09:15:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6131,6131,'2025-01-10 09:20:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6132,6132,'2025-01-10 09:25:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6141,6141,'2025-01-10 09:30:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6142,6142,'2025-01-10 09:35:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6151,6151,'2025-01-10 09:40:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6152,6152,'2025-01-10 09:45:00',
 100.00,'credit','2025-01-01 00:00:00'),

(6301,6301,'2025-01-11 10:00:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6302,6302,'2025-01-11 10:05:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6303,6303,'2025-01-11 10:10:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6304,6304,'2025-01-11 10:15:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6305,6305,'2025-01-11 10:20:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6306,6306,'2025-01-11 10:25:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6307,6307,'2025-01-11 10:30:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6308,6308,'2025-01-11 10:35:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6309,6309,'2025-01-11 10:40:00',
 200.00,'credit','2025-01-01 00:00:00'),

(6310,6310,'2025-01-11 10:45:00',
 200.00,'credit','2025-01-01 00:00:00');


/* =========================================================
   FIFA Games
   ========================================================= */

INSERT INTO FIFA_Games
(gameId,memberId,teamFor,teamAgainst,date,location,score)
VALUES
(5001,5004,'Montreal Strikers','Laval Eagles',
 '2025-06-15 15:00:00','Montreal Stadium','2-1'),

(5002,5005,'Montreal Strikers','Laval Eagles',
 '2025-06-15 15:00:00','Montreal Stadium','2-1'),

(5003,5006,'Montreal Strikers','Laval Eagles',
 '2025-06-15 15:00:00','Montreal Stadium','2-1'),

(5004,5007,'Montreal Strikers','Quebec Lions',
 '2025-07-20 18:00:00','Laval Complex','3-3'),

(5005,5008,'Montreal Strikers','Quebec Lions',
 '2025-07-20 18:00:00','Laval Complex','3-3'),

(5101,5111,'Montreal Youth A','Quebec Youth A',
 '2025-07-01 12:00:00','Montreal Stadium','0-1'),

(5102,5112,'Montreal Youth B','Quebec Youth B',
 '2025-07-02 12:00:00','Montreal Stadium','0-1'),

(5103,5113,'Montreal Youth C','Quebec Youth C',
 '2025-07-03 12:00:00','Montreal Stadium','0-1'),

(5104,5114,'Montreal Youth D','Quebec Youth D',
 '2025-07-04 12:00:00','Montreal Stadium','0-1'),

(5105,5115,'Montreal Youth E','Quebec Youth E',
 '2025-07-05 12:00:00','Montreal Stadium','0-1'),

(6201,6111,'West Youth','Ottawa Youth',
 '2023-06-01 14:00:00','Montreal','2-1'),

(6202,6111,'West Youth','Toronto Youth',
 '2023-08-01 14:00:00','Toronto','1-1'),

(6203,6111,'West Youth','Quebec Youth',
 '2024-05-01 14:00:00','Quebec City','1-0'),

(6204,6111,'West Youth','Laval Youth',
 '2024-08-01 14:00:00','Laval','0-2'),

(6205,6111,'West Youth','Gatineau Youth',
 '2025-05-01 14:00:00','Gatineau','3-2'),

(6211,6121,'East Youth','Ottawa Youth',
 '2023-06-02 14:00:00','Montreal','2-1'),

(6212,6121,'East Youth','Toronto Youth',
 '2023-08-02 14:00:00','Toronto','1-1'),

(6213,6121,'East Youth','Quebec Youth',
 '2024-05-02 14:00:00','Quebec City','1-0'),

(6214,6121,'East Youth','Laval Youth',
 '2024-08-02 14:00:00','Laval','0-2'),

(6215,6121,'East Youth','Gatineau Youth',
 '2025-05-02 14:00:00','Gatineau','3-2'),

(6221,6131,'Laval North Youth','Ottawa Youth',
 '2023-06-03 14:00:00','Montreal','2-1'),

(6222,6131,'Laval North Youth','Toronto Youth',
 '2023-08-03 14:00:00','Toronto','1-1'),

(6223,6131,'Laval North Youth','Quebec Youth',
 '2024-05-03 14:00:00','Quebec City','1-0'),

(6224,6131,'Laval North Youth','Montreal Youth',
 '2024-08-03 14:00:00','Montreal','0-2'),

(6225,6131,'Laval North Youth','Gatineau Youth',
 '2025-05-03 14:00:00','Gatineau','3-2'),

(6231,6141,'South Shore Youth','Ottawa Youth',
 '2023-06-04 14:00:00','Montreal','2-1'),

(6232,6141,'South Shore Youth','Toronto Youth',
 '2023-08-04 14:00:00','Toronto','1-1'),

(6233,6141,'South Shore Youth','Quebec Youth',
 '2024-05-04 14:00:00','Quebec City','1-0'),

(6234,6141,'South Shore Youth','Laval Youth',
 '2024-08-04 14:00:00','Laval','0-2'),

(6235,6141,'South Shore Youth','Gatineau Youth',
 '2025-05-04 14:00:00','Gatineau','3-2'),

(6241,6151,'West Island Youth','Ottawa Youth',
 '2023-06-05 14:00:00','Montreal','2-1'),

(6242,6151,'West Island Youth','Toronto Youth',
 '2023-08-05 14:00:00','Toronto','1-1'),

(6243,6151,'West Island Youth','Quebec Youth',
 '2024-05-05 14:00:00','Quebec City','1-0'),

(6244,6151,'West Island Youth','Laval Youth',
 '2024-08-05 14:00:00','Laval','0-2'),

(6245,6151,'West Island Youth','Gatineau Youth',
 '2025-05-05 14:00:00','Gatineau','3-2'),

(6251,6112,'West Youth B','Laval Youth B',
 '2025-07-01 14:00:00','Montreal','1-0'),

(6252,6122,'East Youth B','Laval Youth B',
 '2025-07-02 14:00:00','Montreal','1-0'),

(6253,6132,'Laval North Youth B','Montreal Youth B',
 '2025-07-03 14:00:00','Laval','1-0'),

(6254,6142,'South Shore Youth B','Montreal Youth B',
 '2025-07-04 14:00:00','Longueuil','1-0'),

(6255,6152,'West Island Youth B','Montreal Youth B',
 '2025-07-05 14:00:00','Pointe-Claire','1-0');


/* =========================================================
   Team Formations
   ========================================================= */

INSERT INTO TeamFormations
(id,locationId,headCoachId,teamName)
VALUES
(5001,5001,5002,'Montreal Boys U14 A'),
(5002,5001,5002,'Montreal Boys U14 B'),
(5003,5001,5002,'Montreal Girls U12 A'),
(5004,5001,5002,'Montreal Senior Boys'),
(5005,5002,5012,'Laval Boys U14 A'),

(5101,5101,5121,'Montreal MultiRole Stars'),
(5102,5102,5126,'Laval Query Opponents'),

(5111,5101,5121,'Montreal Keeper Team A'),
(5112,5101,5122,'Montreal Keeper Team B'),
(5113,5101,5123,'Montreal Keeper Team C'),
(5114,5101,5124,'Montreal Keeper Team D'),
(5115,5101,5125,'Montreal Keeper Team E'),

(6401,6001,6051,'West Montreal Senior'),
(6402,6002,6052,'East Montreal Senior'),
(6403,6003,6053,'North Laval Senior'),
(6404,6004,6054,'South Shore Senior'),
(6405,6005,6055,'West Island Senior');


/* =========================================================
   Team Formation Players
   ========================================================= */

INSERT INTO TeamFormationPlayers
(formationId,memberId,role)
VALUES
(5001,5004,'Striker'),
(5001,5007,'Goalkeeper'),
(5001,5008,'Right Fullback'),
(5001,5009,'Center Back'),
(5001,5010,'Central Midfielder'),

(5002,5009,'Striker'),
(5002,5010,'Central Midfielder'),

(5003,5005,'Left Winger'),
(5004,5006,'Central Midfielder'),

(5005,5014,'Striker'),
(5005,5015,'Central Midfielder'),
(5005,5016,'Left Fullback'),

(5101,5101,'Goalkeeper'),
(5101,5102,'Right Fullback'),
(5101,5103,'Sweeper'),
(5101,5104,'Defending Midfielder'),
(5101,5105,'Striker'),

(5102,5106,'Striker'),
(5102,5107,'Right Fullback'),
(5102,5108,'Sweeper'),
(5102,5109,'Defending Midfielder'),
(5102,5110,'Left Winger'),

(5111,5111,'Goalkeeper'),
(5112,5112,'Goalkeeper'),
(5113,5113,'Goalkeeper'),
(5114,5114,'Goalkeeper'),
(5115,5115,'Goalkeeper'),

(6401,6301,'Goalkeeper'),
(6401,6302,'Striker'),

(6402,6303,'Goalkeeper'),
(6402,6304,'Striker'),

(6403,6305,'Goalkeeper'),
(6403,6306,'Striker'),

(6404,6307,'Goalkeeper'),
(6404,6308,'Striker'),

(6405,6309,'Goalkeeper'),
(6405,6310,'Striker');


/* =========================================================
   Team Sessions
   ========================================================= */

INSERT INTO TeamSessions
(id,team1,team2,sessionType,startTime,address,
 score,team1Score,team2Score)
VALUES
(5001,5001,5005,'Game',
 '2025-03-10 14:00:00',
 '1234 Sherbrooke St W',
 '3-1',3,1),

(5002,5001,5002,'Training',
 '2025-03-15 10:00:00',
 '1234 Sherbrooke St W',
 NULL,NULL,NULL),

(5003,5002,5005,'Game',
 '2025-04-05 16:00:00',
 '5678 Blvd Saint-Martin',
 '2-2',2,2),

(5004,5003,5005,'Game',
 '2025-04-12 11:00:00',
 '1234 Sherbrooke St W',
 '1-0',1,0),

(5005,5001,5002,'Game',
 '2025-05-01 15:00:00',
 '1234 Sherbrooke St W',
 '4-2',4,2),

(5201,5101,5102,'Game',
 '2025-01-10 14:00:00',
 'Montreal Query Centre',
 '2-1',2,1),

(5202,5101,5102,'Game',
 '2025-02-10 14:00:00',
 'Montreal Query Centre',
 '1-2',1,2),

(5203,5101,5102,'Game',
 '2025-03-10 14:00:00',
 'Montreal Query Centre',
 '3-1',3,1),

(5204,5101,5102,'Game',
 '2025-04-10 14:00:00',
 'Montreal Query Centre',
 '2-2',2,2),

(5205,5101,5102,'Game',
 '2025-05-10 14:00:00',
 'Montreal Query Centre',
 '1-0',1,0),

(5211,5111,5102,'Game',
 '2025-06-01 14:00:00',
 'Montreal Query Centre',
 '0-1',0,1),

(5212,5112,5102,'Game',
 '2025-06-02 14:00:00',
 'Montreal Query Centre',
 '0-1',0,1),

(5213,5113,5102,'Game',
 '2025-06-03 14:00:00',
 'Montreal Query Centre',
 '0-1',0,1),

(5214,5114,5102,'Game',
 '2025-06-04 14:00:00',
 'Montreal Query Centre',
 '0-1',0,1),

(5215,5115,5102,'Game',
 '2025-06-05 14:00:00',
 'Montreal Query Centre',
 '0-1',0,1),

(5299,5101,5102,'Training',
 '2026-08-24 18:00:00',
 'Montreal Query Centre',
 NULL,NULL,NULL),

(6501,6401,6402,'Game',
 '2025-01-15 14:00:00',
 'West Montreal Field',
 '2-1',2,1),

(6502,6401,6403,'Game',
 '2025-01-22 14:00:00',
 'West Montreal Field',
 '1-1',1,1),

(6503,6401,6404,'Game',
 '2025-02-05 14:00:00',
 'West Montreal Field',
 '3-1',3,1),

(6504,6401,6405,'Game',
 '2025-02-19 14:00:00',
 'West Montreal Field',
 '1-2',1,2),

(6505,6402,6403,'Game',
 '2025-03-05 14:00:00',
 'East Montreal Field',
 '2-0',2,0),

(6506,6402,6404,'Game',
 '2025-03-19 14:00:00',
 'East Montreal Field',
 '2-2',2,2),

(6507,6402,6405,'Game',
 '2025-04-02 14:00:00',
 'East Montreal Field',
 '1-0',1,0),

(6508,6403,6404,'Game',
 '2025-04-16 14:00:00',
 'North Laval Field',
 '0-1',0,1),

(6509,6403,6405,'Game',
 '2025-04-30 14:00:00',
 'North Laval Field',
 '2-1',2,1),

(6510,6404,6405,'Game',
 '2025-05-14 14:00:00',
 'South Shore Field',
 '1-1',1,1);


/* =========================================================
   Session Players
   ========================================================= */

INSERT INTO SessionPlayers
(sessionId,formationId,memberId,role)
VALUES

(5001,5001,5004,'Striker'),
(5001,5001,5007,'Goalkeeper'),
(5001,5001,5008,'Right Fullback'),
(5001,5001,5009,'Center Back'),
(5001,5001,5010,'Central Midfielder'),
(5001,5005,5014,'Striker'),
(5001,5005,5015,'Central Midfielder'),
(5001,5005,5016,'Left Fullback'),

(5002,5001,5004,'Striker'),
(5002,5001,5007,'Goalkeeper'),
(5002,5001,5008,'Right Fullback'),
(5002,5002,5009,'Striker'),
(5002,5002,5010,'Central Midfielder'),

(5003,5002,5009,'Striker'),
(5003,5002,5010,'Central Midfielder'),
(5003,5005,5014,'Striker'),
(5003,5005,5015,'Central Midfielder'),
(5003,5005,5016,'Left Fullback'),

(5004,5003,5005,'Left Winger'),
(5004,5005,5014,'Striker'),
(5004,5005,5015,'Central Midfielder'),
(5004,5005,5016,'Left Fullback'),

(5005,5001,5004,'Striker'),
(5005,5001,5007,'Goalkeeper'),
(5005,5001,5008,'Right Fullback'),
(5005,5002,5009,'Striker'),
(5005,5002,5010,'Central Midfielder'),

(5201,5101,5101,'Goalkeeper'),
(5201,5101,5102,'Right Fullback'),
(5201,5101,5103,'Sweeper'),
(5201,5101,5104,'Defending Midfielder'),
(5201,5101,5105,'Striker'),
(5201,5102,5106,'Striker'),
(5201,5102,5107,'Right Fullback'),
(5201,5102,5108,'Sweeper'),
(5201,5102,5109,'Defending Midfielder'),
(5201,5102,5110,'Left Winger'),

(5202,5101,5101,'Right Fullback'),
(5202,5101,5102,'Sweeper'),
(5202,5101,5103,'Defending Midfielder'),
(5202,5101,5104,'Striker'),
(5202,5101,5105,'Goalkeeper'),
(5202,5102,5106,'Striker'),
(5202,5102,5107,'Right Fullback'),
(5202,5102,5108,'Sweeper'),
(5202,5102,5109,'Defending Midfielder'),
(5202,5102,5110,'Left Winger'),

(5203,5101,5101,'Sweeper'),
(5203,5101,5102,'Defending Midfielder'),
(5203,5101,5103,'Striker'),
(5203,5101,5104,'Goalkeeper'),
(5203,5101,5105,'Right Fullback'),
(5203,5102,5106,'Striker'),
(5203,5102,5107,'Right Fullback'),
(5203,5102,5108,'Sweeper'),
(5203,5102,5109,'Defending Midfielder'),
(5203,5102,5110,'Left Winger'),

(5204,5101,5101,'Defending Midfielder'),
(5204,5101,5102,'Striker'),
(5204,5101,5103,'Goalkeeper'),
(5204,5101,5104,'Right Fullback'),
(5204,5101,5105,'Sweeper'),
(5204,5102,5106,'Striker'),
(5204,5102,5107,'Right Fullback'),
(5204,5102,5108,'Sweeper'),
(5204,5102,5109,'Defending Midfielder'),
(5204,5102,5110,'Left Winger'),

(5205,5101,5101,'Striker'),
(5205,5101,5102,'Goalkeeper'),
(5205,5101,5103,'Right Fullback'),
(5205,5101,5104,'Sweeper'),
(5205,5101,5105,'Defending Midfielder'),
(5205,5102,5106,'Striker'),
(5205,5102,5107,'Right Fullback'),
(5205,5102,5108,'Sweeper'),
(5205,5102,5109,'Defending Midfielder'),
(5205,5102,5110,'Left Winger'),

(5211,5111,5111,'Goalkeeper'),
(5211,5102,5106,'Striker'),

(5212,5112,5112,'Goalkeeper'),
(5212,5102,5107,'Right Fullback'),

(5213,5113,5113,'Goalkeeper'),
(5213,5102,5108,'Sweeper'),

(5214,5114,5114,'Goalkeeper'),
(5214,5102,5109,'Defending Midfielder'),

(5215,5115,5115,'Goalkeeper'),
(5215,5102,5110,'Left Winger'),

(5299,5101,5101,'Goalkeeper'),
(5299,5101,5102,'Right Fullback'),
(5299,5101,5103,'Sweeper'),
(5299,5101,5104,'Defending Midfielder'),
(5299,5101,5105,'Striker'),
(5299,5102,5106,'Striker'),
(5299,5102,5107,'Right Fullback'),
(5299,5102,5108,'Sweeper'),
(5299,5102,5109,'Defending Midfielder'),
(5299,5102,5110,'Left Winger'),

(6501,6401,6301,'Goalkeeper'),
(6501,6401,6302,'Striker'),
(6501,6402,6303,'Goalkeeper'),
(6501,6402,6304,'Striker'),

(6502,6401,6301,'Goalkeeper'),
(6502,6401,6302,'Striker'),
(6502,6403,6305,'Goalkeeper'),
(6502,6403,6306,'Striker'),

(6503,6401,6301,'Goalkeeper'),
(6503,6401,6302,'Striker'),
(6503,6404,6307,'Goalkeeper'),
(6503,6404,6308,'Striker'),

(6504,6401,6301,'Goalkeeper'),
(6504,6401,6302,'Striker'),
(6504,6405,6309,'Goalkeeper'),
(6504,6405,6310,'Striker'),

(6505,6402,6303,'Goalkeeper'),
(6505,6402,6304,'Striker'),
(6505,6403,6305,'Goalkeeper'),
(6505,6403,6306,'Striker'),

(6506,6402,6303,'Goalkeeper'),
(6506,6402,6304,'Striker'),
(6506,6404,6307,'Goalkeeper'),
(6506,6404,6308,'Striker'),

(6507,6402,6303,'Goalkeeper'),
(6507,6402,6304,'Striker'),
(6507,6405,6309,'Goalkeeper'),
(6507,6405,6310,'Striker'),

(6508,6403,6305,'Goalkeeper'),
(6508,6403,6306,'Striker'),
(6508,6404,6307,'Goalkeeper'),
(6508,6404,6308,'Striker'),

(6509,6403,6305,'Goalkeeper'),
(6509,6403,6306,'Striker'),
(6509,6405,6309,'Goalkeeper'),
(6509,6405,6310,'Striker'),

(6510,6404,6307,'Goalkeeper'),
(6510,6404,6308,'Striker'),
(6510,6405,6309,'Goalkeeper'),
(6510,6405,6310,'Striker');


/* =========================================================
   Email Logs
   ========================================================= */

INSERT INTO EmailLogs
(id,sentDate,sender,receiver,subject,bodyPreview)
VALUES
(
    5001,
    '2025-03-08 08:00:00',
    'Montreal Central',
    'lucas@gmail.com',
    'Montreal Boys U14 A Monday 10-March-2025 2:00 PM game session',
    'Club Member: Lucas Gagnon Role: Striker Head Coach: Marc Lavoie Head Coach Email: mlavoie@cscs'
),

(
    5002,
    '2025-03-08 08:00:00',
    'Montreal Central',
    'gabriel@gmail.com',
    'Montreal Boys U14 A Monday 10-March-2025 2:00 PM game session',
    'Club Member: Gabriel Lavoie Role: Goalkeeper Head Coach: Marc Lavoie Head Coach Email: mlavoie@c'
);


/* =========================================================
   End of Representative Data Population
   ========================================================= */
