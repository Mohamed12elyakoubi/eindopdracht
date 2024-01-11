-- -- phpMyAdmin SQL Dump
-- -- version 5.2.0
-- -- https://www.phpmyadmin.net/
-- --
-- -- Host: 127.0.0.1
-- -- Gegenereerd op: 05 jan 2024 om 16:40
-- -- Serverversie: 10.4.27-MariaDB
-- -- PHP-versie: 8.1.12

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- --
-- -- Database: `eindopdracht`
-- --

-- -- --------------------------------------------------------

-- --
-- -- Tabelstructuur voor tabel `admin`
-- --

-- CREATE TABLE `admin` (
--   `ID` int(11) NOT NULL,
--   `name` varchar(255) NOT NULL,
--   `email` varchar(255) NOT NULL,
--   `Wachtwoord` varchar(255) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Gegevens worden geëxporteerd voor tabel `admin`
-- --

-- INSERT INTO `admin` (`ID`, `name`, `email`, `Wachtwoord`) VALUES
-- (13, 'the best admin', 'elyakoubi1240@gmail.com', '$2y$10$QvleIit3la7PoQEOcZIELO9X23JGI.64JXlTX.tRGSyC.Mq9s7IUW'),
-- (15, 'Osman OZ', 'osman@gmail.com', '$2y$10$9ad0/p4wpChRGKzOxoDKtO3iqqQHhjFOnponHa3JhyK9OpMnYXrjS');

-- -- --------------------------------------------------------

-- --
-- -- Tabelstructuur voor tabel `auto`
-- --

-- CREATE TABLE `auto` (
--   `AutoID` int(11) NOT NULL,
--   `Name` varchar(200) NOT NULL,
--   `Merk` varchar(50) NOT NULL,
--   `Model` varchar(50) NOT NULL,
--   `type` varchar(50) NOT NULL,
--   `Jaar` date DEFAULT NULL,
--   `Kenteken` varchar(20) NOT NULL,
--   `kmafstand` int(11) NOT NULL,
--   `Color` varchar(50) NOT NULL,
--   `Transmissie` varchar(250) NOT NULL,
--   `Brandstof` varchar(50) NOT NULL,
--   `Prijs` int(11) NOT NULL,
--   `imagename` varchar(200) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Gegevens worden geëxporteerd voor tabel `auto`
-- --

-- INSERT INTO `auto` (`AutoID`, `Name`, `Merk`, `Model`, `type`, `Jaar`, `Kenteken`, `kmafstand`, `Color`, `Transmissie`, `Brandstof`, `Prijs`, `imagename`) VALUES
-- (18, 'Volkswagen Golf GTI 2.0 TSI', 'VW', 'Golf 7 GTI', 'Hatchback', '2019-02-10', 'FN-102-1', 10291, 'Grijs', 'Automaat', 'Benzine', 120, 'img/GTI.png'),
-- (19, 'Mercedes-Benz G 63', 'Mercedes', 'G 63', 'suv', '2019-10-10', 'TZ-114-H', 20000, 'Wit', 'Automaat', 'Benzine', 150, 'img/gwagon (1).png'),
-- (20, 'Audi A3 Sportback 2.0 TDI', 'Audi', 'A3', 'Hatchback', '2018-02-10', '12-bba-9', 40000, 'Zwart', 'Handschakel', 'Diesel', 70, 'img/audia3s.png'),
-- (21, 'Mercedes-Benz GLC Coupe', 'Mercedes', 'GLC 350e ', 'suv', '2021-10-20', 'TX-844-T', 30500, 'Zwart', 'Automaat', 'Diesel', 130, 'img/GLC (1).JPG'),
-- (22, 'Audi RS7 Sportback', 'Audi', 'RS 7', 'sedan', '2022-10-10', 'RS-781-1', 10000, 'Zwart', 'Automaat', 'Benzine', 250, 'img/rs7 (1).png'),
-- (23, 'Seat Ibiza 1.4 TDI', 'Seat', 'Ibiza', 'Hatchback', '2019-02-10', 'WJ-191-0', 24050, 'Wit', 'Automaat', 'Benzine', 50, 'img/ibiza1 (1).png'),
-- (25, 'Ibiza 1.6 TDI', 'Seat', 'Ibiza', 'Hatchback', '2020-08-01', '8800 IHW', 40000, 'Dark Blue', 'Handschakel', 'Diesel', 40, 'img/seat 1(1).png');

-- -- --------------------------------------------------------

-- --
-- -- Tabelstructuur voor tabel `klanten`
-- --

-- CREATE TABLE `klanten` (
--   `KlantID` int(11) NOT NULL,
--   `Klant_naam` varchar(100) NOT NULL,
--   `klant_achternaam` varchar(100) NOT NULL,
--   `birthday` date NOT NULL,
--   `Adres` varchar(255) NOT NULL,
--   `Rijbewijsnummer` varchar(20) NOT NULL,
--   `Telefoonnummer` varchar(15) DEFAULT NULL,
--   `email` varchar(100) NOT NULL,
--   `password` varchar(120) DEFAULT NULL,
--   `AanmaakDatum` date NOT NULL DEFAULT current_timestamp()
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Gegevens worden geëxporteerd voor tabel `klanten`
-- --

-- INSERT INTO `klanten` (`KlantID`, `Klant_naam`, `klant_achternaam`, `birthday`, `Adres`, `Rijbewijsnummer`, `Telefoonnummer`, `email`, `password`, `AanmaakDatum`) VALUES
-- (4, 'Ayoub', 'El JR', '2001-02-12', 'mercatorplein 13-1 Amsterdam', '561830012', '672838192', 'admin@admin.com', '$2y$10$PJreMoWyE9RTgyHIZjka4OiqyqJVU9SjsRE63n6eW7FsVC1M8Q7Wu', '2023-12-24'),
-- (5, 'klant1', 'klant11', '2005-12-12', 'Bart van Hovestraat 1-1', '2113453555', '7818267182', 'klant1@gmail.com', '$2y$10$0q8PTfA4UAkZb70VC.LHm.10D8LKsExmX4LKOhDYbFM6rH7mhPxqS', '2023-12-25'),
-- (7, 'code is', 'hala', '2007-01-08', 'anastraat 13-1', '000000000', '675282637', 'code@gmail.com', '$2y$10$Rh30TVRExVMnvElzDKpIi.j54qvH6duc/PoTrmO6trGSYnaL23xRu', '2023-12-27'),
-- (9, 'Klant', 'De beste', '1987-02-12', 'Bart van heren 1-1 amsterdam1325', '182966819', '675858514', 'klant69@gmail.com', '$2y$10$u3F6pvIyG6o.1c.JOYnxKezIWa7jbKGHQm3gc3vftr2QkonPVbUMu', '2024-01-05');

-- -- --------------------------------------------------------

-- --
-- -- Tabelstructuur voor tabel `verhuringen`
-- --

-- CREATE TABLE `verhuringen` (
--   `VerhuurID` int(11) NOT NULL,
--   `StartVerhuurdatum` date NOT NULL,
--   `EindVerhuurdatum` date NOT NULL,
--   `KlantID` int(11) NOT NULL,
--   `AutoID` int(11) NOT NULL,
--   `Kosten` int(11) NOT NULL
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --
-- -- Gegevens worden geëxporteerd voor tabel `verhuringen`
-- --

-- INSERT INTO `verhuringen` (`VerhuurID`, `StartVerhuurdatum`, `EindVerhuurdatum`, `KlantID`, `AutoID`, `Kosten`) VALUES
-- (4, '2024-01-04', '2024-01-27', 7, 25, 920),
-- (8, '2024-01-05', '2024-01-12', 5, 21, 910);

-- --
-- -- Triggers `verhuringen`
-- --
-- DELIMITER $$
-- CREATE TRIGGER `calculate_cost_trigger` BEFORE INSERT ON `verhuringen` FOR EACH ROW BEGIN
--     DECLARE auto_prijs INT;

--     -- Haal de prijs per dag op uit de auto tabel
--     SELECT Prijs INTO auto_prijs FROM auto WHERE AutoID = NEW.AutoID;

--     -- Bereken de kosten op basis van de prijs per dag en het aantal dagen
--     SET NEW.Kosten = auto_prijs * (DATEDIFF(NEW.EindVerhuurdatum, NEW.StartVerhuurdatum));
-- END
-- $$
-- DELIMITER ;

-- --
-- -- Indexen voor geëxporteerde tabellen
-- --

-- --
-- -- Indexen voor tabel `admin`
-- --
-- ALTER TABLE `admin`
--   ADD PRIMARY KEY (`ID`);

-- --
-- -- Indexen voor tabel `auto`
-- --
-- ALTER TABLE `auto`
--   ADD PRIMARY KEY (`AutoID`);

-- --
-- -- Indexen voor tabel `klanten`
-- --
-- ALTER TABLE `klanten`
--   ADD PRIMARY KEY (`KlantID`);

-- --
-- -- Indexen voor tabel `verhuringen`
-- --
-- ALTER TABLE `verhuringen`
--   ADD PRIMARY KEY (`VerhuurID`),
--   ADD KEY `KlantID` (`KlantID`),
--   ADD KEY `AutoID` (`AutoID`);

-- --
-- -- AUTO_INCREMENT voor geëxporteerde tabellen
-- --

-- --
-- -- AUTO_INCREMENT voor een tabel `admin`
-- --
-- ALTER TABLE `admin`
--   MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

-- --
-- -- AUTO_INCREMENT voor een tabel `auto`
-- --
-- ALTER TABLE `auto`
--   MODIFY `AutoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

-- --
-- -- AUTO_INCREMENT voor een tabel `klanten`
-- --
-- ALTER TABLE `klanten`
--   MODIFY `KlantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- --
-- -- AUTO_INCREMENT voor een tabel `verhuringen`
-- --
-- ALTER TABLE `verhuringen`
--   MODIFY `VerhuurID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- --
-- -- Beperkingen voor geëxporteerde tabellen
-- --

-- --
-- -- Beperkingen voor tabel `verhuringen`
-- --
-- ALTER TABLE `verhuringen`
--   ADD CONSTRAINT `verhuringen_ibfk_1` FOREIGN KEY (`KlantID`) REFERENCES `klanten` (`KlantID`),
--   ADD CONSTRAINT `verhuringen_ibfk_2` FOREIGN KEY (`AutoID`) REFERENCES `auto` (`AutoID`);
-- COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
