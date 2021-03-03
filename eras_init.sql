-- ERAS initial database
-- Database: MariaDB/MySQL

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

CREATE TABLE `ERAS` (
  `a` int(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `fb_system`
--

CREATE TABLE `fb_system` (
  `naam` varchar(255) NOT NULL DEFAULT 'ERAS',
  `version_major` varchar(10) NOT NULL,
  `version_minor` varchar(10) NOT NULL,
  `valid` int(1) NOT NULL DEFAULT 1,
  `debug` int(1) NOT NULL DEFAULT 0,
  `deploy_directory` varchar(255) NOT NULL DEFAULT 'eras',
  `db_version_major` varchar(10) NOT NULL,
  `db_version_minor` varchar(10) NOT NULL,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fb_system`
--

INSERT INTO `fb_system` (`naam`, `version_major`, `version_minor`, `valid`, `debug`, `deploy_directory`, `db_version_major`, `db_version_minor`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
('eras', '1', '03', 1, 0, 'ERAS', '1', '03', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

--
-- Indexes for table `fb_system`
--
ALTER TABLE `fb_system`
  ADD PRIMARY KEY (`naam`),
  ADD UNIQUE KEY `version_major` (`naam`,`version_major`,`version_minor`);

--
-- **** ALLES HIERONDER KAN NAAR ACCEPTATIE EN PRODUCTIE OVERGEZET WORDEN ****
--

--
-- Tabelstructuur voor tabel `fb_annuleringsverzekering`
--

CREATE TABLE `fb_annuleringsverzekering` (
  `id` int(11) NOT NULL DEFAULT 0,
  `code` int(2) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `afsluitkosten` decimal(4,2) NOT NULL DEFAULT '0.00',
  `percentage` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `btw` decimal(4,2) NOT NULL DEFAULT '0.00',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `fb_annuleringsverzekering`
--

INSERT INTO `fb_annuleringsverzekering` (`id`, `code`, `naam`, `afsluitkosten`, `percentage`, `btw`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
(1, 1, 'Geen', '0.00', '0.0000', '0.00', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(2, 2, 'Gewoon', '3.50', '0.0550', '21.00', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(3, 3, 'All-Risk', '3.50', '0.0700', '21.00', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');


--
-- Tabelstructuur voor tabel `fb_betaalwijze`
--

CREATE TABLE `fb_betaalwijze` (
  `id` int(11) NOT NULL DEFAULT 0,
  `code` int(2) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `kosten` decimal(4,2) NOT NULL DEFAULT '0.00',
  `percentage` decimal(5,4) NOT NULL DEFAULT '0.0000',
  `btw` decimal(4,2) NOT NULL DEFAULT '0.00',
  `actief` int(1) NOT NULL DEFAULT 0,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `fb_betaalwijze`
--

INSERT INTO `fb_betaalwijze` (`id`, `code`, `naam`, `kosten`, `percentage`, `btw`, `actief`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
(1, 1, 'iDeal', '0.00', '0.0000', '0.00', '1', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(2, 2, 'Overschrijving', '0.00', '0.0000', '0.00', '1', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(3, 4, 'Incasso in termijnen', '7.50', '0.0000', '0.00', '1', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(4, 8, 'Contant', '0.00', '0.0000', '0.00', '1', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(5, 16, 'Creditcard', '3.50', '0.0000', '0.00', '0', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(6, 32, 'Tegoedbon (voucher)', '0.00', '0.0000', '0.00', '1', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(7, 64, 'Gereserveerd', '0.00', '0.0000', '0.00', '0', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(8, 128, 'Gereserveerd', '0.00', '0.0000', '0.00', '0', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(9, 256, 'Gereserveerd', '0.00', '0.0000', '0.00', '0', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

--
-- Tabelstructuur voor tabel `fb_deelnemer`
--

CREATE TABLE `fb_deelnemer` (
  `id` int(11) NOT NULL DEFAULT 0,
  `inschrijving_id` int(11) NOT NULL DEFAULT 0,
  `persoon_id` int(11) NOT NULL DEFAULT 0,
  `totaalbedrag` decimal(9,2) NOT NULL DEFAULT '0.00',
  `status` int(2) NOT NULL DEFAULT 0,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_deelnemer_heeft_optie`
--

CREATE TABLE `fb_deelnemer_heeft_optie` (
  `id` int(11) NOT NULL DEFAULT 0,
  `optie_id` int(11) NOT NULL DEFAULT 0,
  `deelnemer_id` int(11) NOT NULL DEFAULT 0,
  `waarde` varchar(512) NOT NULL DEFAULT '',
  `prijs` decimal(9,2) NOT NULL DEFAULT '0.00',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_evenement`
--

CREATE TABLE `fb_evenement` (
  `id` int(11) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `categorie` int(2) NOT NULL DEFAULT 0,
  `korte_omschrijving` text NOT NULL DEFAULT '',
  `lange_omschrijving` text NOT NULL DEFAULT '',
  `datum_begin` date NOT NULL DEFAULT '0000-00-00',
  `datum_eind` date NOT NULL DEFAULT '0000-00-00',
  `aantal_dagen` int(3) NOT NULL DEFAULT 0,
  `frequentie` varchar(255) NOT NULL DEFAULT '',
  `inschrijving_begin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `inschrijving_eind` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `extra_deelnemer_gegevens` int(2) NOT NULL DEFAULT '0',
  `extra_contact_gegevens` int(2) NOT NULL DEFAULT '0',
  `prijs` decimal(9,2) NOT NULL DEFAULT '0.00',
  `betaalwijze` int(2) NOT NULL DEFAULT '0',
  `max_deelnemers` int(11) NOT NULL DEFAULT 0,
  `annuleringsverzekering` int(1) NOT NULL DEFAULT 0,
  `account_nodig` int(1) NOT NULL DEFAULT 0,
  `groepsinschrijving` int(1) NOT NULL DEFAULT 0,
  `status` int(2) NOT NULL DEFAULT 0,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_evenement_heeft_optie`
--

CREATE TABLE `fb_evenement_heeft_optie` (
  `id` int(11) NOT NULL DEFAULT 0,
  `evenement_id` int(11) NOT NULL DEFAULT 0,
  `optie_id` int(11) NOT NULL DEFAULT 0,
  `volgorde` int(11) NOT NULL DEFAULT '0',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_factuur`
--

CREATE TABLE `fb_factuur` (
  `id` int(11) NOT NULL DEFAULT 1,
  `inschrijving_id` int(11) NOT NULL DEFAULT 0,
  `factuurnummer` varchar(255) NOT NULL DEFAULT '0',
  `verzonden` int(1) NOT NULL DEFAULT '0',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_gebruiker`
--

CREATE TABLE `fb_gebruiker` (
  `id` int(11) NOT NULL DEFAULT 0,
  `userid` varchar(255) NOT NULL DEFAULT '',
  `persoon_id` int(11) DEFAULT NULL,
  `rol` int(11) NOT NULL DEFAULT 0,
  `actief` int(1) NOT NULL DEFAULT '1',
  `wachtwoord` varchar(255) NOT NULL DEFAULT '',
  `wachtwoord_wijzig_datum` datetime NULL,
  `laatste_login_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `laatste_login_adres` varchar(255) DEFAULT NULL,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `fb_gebruiker`
--

INSERT INTO `fb_gebruiker` (`id`, `userid`, `persoon_id`, `rol`, `actief`, `wachtwoord`, `wachtwoord_wijzig_datum`, `laatste_login_datum`, `laatste_login_adres`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
(1, 'root', NULL, 5, 1, '$2y$10$1OyhhZln5F5u.gF7NBecgOePWPer4OdZ1Khx2MjGLsi.se1pLZnIS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');


--
-- Tabelstructuur voor tabel `fb_inschrijving`
--

CREATE TABLE `fb_inschrijving` (
  `id` int(11) NOT NULL DEFAULT 0,
  `evenement_id` int(11) NOT NULL DEFAULT 0,
  `contactpersoon_id` int(11) NOT NULL DEFAULT 0,
  `datum_inschrijving` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `annuleringsverzekering_afgesloten` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `totaalbedrag` decimal(9,2) NOT NULL DEFAULT '0.00',
  `reeds_betaald` decimal(9,2) DEFAULT NULL,
  `nog_te_betalen` decimal(9,2) DEFAULT NULL,
  `korting` decimal(9,2) DEFAULT NULL,
  `betaald_per_voucher` decimal(9,2) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT 0,
  `betaalwijze` int(1) DEFAULT 0,
  `annuleringsverzekering` int(1) DEFAULT 0,
  `status` int(2) NOT NULL DEFAULT 0,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_inschrijving_heeft_optie`
--

CREATE TABLE `fb_inschrijving_heeft_optie` (
  `id` int(11) NOT NULL DEFAULT 0,
  `optie_id` int(11) NOT NULL DEFAULT 0,
  `inschrijving_id` int(11) NOT NULL DEFAULT 0,
  `waarde` varchar(512) NOT NULL DEFAULT '',
  `prijs` decimal(9,2) DEFAULT NULL,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_mailinglist`
--

CREATE TABLE `fb_mailinglist` (
  `id` int(11) NOT NULL DEFAULT 0,
  `evenement_id` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_voucher`
--

CREATE TABLE `fb_voucher` (
  `id` int(11) NOT NULL DEFAULT 0,
  `code` varchar(255) NOT NULL DEFAULT 0,
  `email` varchar(255) DEFAULT NULL,
  `evenement_id` int(11) DEFAULT NULL,
  `oorsprongwaarde` decimal(9,2) NOT NULL DEFAULT '0',
  `restwaarde` decimal(9,2) DEFAULT NULL,
  `verbruikt` decimal(9,2) DEFAULT NULL,
  `vouchertype` int(2) NOT NULL DEFAULT '0',
  `actief` int(1) NOT NULL DEFAULT '1',
  `geldig_tot` datetime NOT NULL,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_keuzes`
--

CREATE TABLE `fb_keuzes` (
  `id` int(11) NOT NULL DEFAULT 0,
  `code` int(2) NOT NULL DEFAULT 0,
  `keuzetype` int(2) NOT NULL DEFAULT '0',
  `naam` varchar(255) NOT NULL DEFAULT '',
  `actief` int(1) NOT NULL DEFAULT '1',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `fb_keuzes`
--

INSERT INTO `fb_keuzes` (`id`, `code`, `keuzetype`, `naam`, `actief`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
(1, 0, 1, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(2, 1, 1, 'Open', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(3, 2, 1, 'Afgesloten', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(4, 3, 1, 'Wachten', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(5, 4, 1, 'Vol', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(6, 5, 1, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(7, 6, 1, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(8, 7, 1, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(9, 9, 1, 'Geannuleerd', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(10, 0, 2, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(11, 1, 2, 'Actief', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(12, 2, 2, 'Niet actief', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(13, 3, 2, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(14, 4, 2, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(15, 5, 2, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(16, 0, 3, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(17, 1, 3, 'Open', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(18, 2, 3, 'Definitief', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(19, 3, 3, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(20, 4, 3, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(21, 5, 3, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(22, 9, 3, 'Geannuleerd', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(23, 0, 4, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(24, 1, 4, 'Klant', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(25, 2, 4, 'Medewerker', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(26, 3, 4, 'Supervisor', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(27, 4, 4, 'Administrator', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(28, 5, 4, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(29, 6, 4, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(30, 7, 4, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(31, 8, 4, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(32, 0, 5, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(33, 1, 5, 'Actief', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(34, 2, 5, 'Niet actief', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(35, 4, 5, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(36, 5, 5, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(37, 6, 5, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(38, 9, 5, 'Geannuleerd', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(39, 0, 6, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(40, 1, 6, 'persoon', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(41, 2, 6, 'persoon per dag', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(42, 3, 6, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(43, 4, 6, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(44, 5, 6, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(45, 0, 7, 'Geen', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(46, 1, 7, 'Boven', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(47, 2, 7, 'Onder', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(48, 3, 7, 'Beide', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(49, 4, 7, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(50, 5, 7, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(51, 1, 8, 'e-Mail adres', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(52, 2, 8, 'Telefoonnummer', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(53, 4, 8, 'Landnaam', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(54, 8, 8, 'Geboortedatum', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(55, 16, 8, 'Geslacht', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(56, 32, 8, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(57, 64, 8, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(58, 128, 8, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(59, 256, 8, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),

(60, 1, 9, 'Tegoedbon', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(61, 2, 9, 'Kortingscode', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(62, 3, 9, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(63, 4, 9, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(64, 5, 9, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(65, 6, 9, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');


--
-- Tabelstructuur voor tabel `fb_contactlog`
--

CREATE TABLE `fb_contactlog` (
  `id` int(11) NOT NULL DEFAULT 0,
  `persoon_id` int(11) NOT NULL DEFAULT 0,
  `tekst` varchar(2048) NOT NULL,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_optie`
--

CREATE TABLE `fb_optie` (
  `id` int(11) NOT NULL DEFAULT 0,
  `per_deelnemer` int(1) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `tekst_voor` varchar(255) NOT NULL DEFAULT '',
  `tekst_achter` varchar(255) NOT NULL DEFAULT '',
  `tooltip_tekst` varchar(255) DEFAULT NULL,
  `heeft_hor_lijn` int(11) NOT NULL DEFAULT '0',
  `optietype` int(11) NOT NULL DEFAULT 0,
  `groep` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `is_default` int(1) DEFAULT NULL,
  `later_wijzigen` int(1) NOT NULL DEFAULT '1',
  `totaal_aantal` int(11) DEFAULT NULL,
  `prijs` decimal(9,2) DEFAULT '0.00',
  `status` int(2) NOT NULL DEFAULT '0',
  `intern_gebruik` int(1) NOT NULL DEFAULT '0',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_persoon`
--

CREATE TABLE `fb_persoon` (
  `id` int(11) NOT NULL DEFAULT 0,
  `voornaam` varchar(255) NOT NULL DEFAULT '',
  `tussenvoegsel` varchar(255) DEFAULT NULL,
  `achternaam` varchar(255) NOT NULL DEFAULT '',
  `geboortedatum` date DEFAULT NULL,
  `geslacht` char(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `banknummer` varchar(255) DEFAULT NULL,
  `telefoonnummer` varchar(255) DEFAULT NULL,
  `straat` varchar(255) NOT NULL DEFAULT '',
  `huisnummer` int(11) NOT NULL DEFAULT 0,
  `toevoeging` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) NOT NULL DEFAULT '',
  `woonplaats` varchar(255) NOT NULL DEFAULT '',
  `landnaam` varchar(255) DEFAULT NULL,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tabelstructuur voor tabel `fb_type`
--

CREATE TABLE `fb_type` (
  `id` int(11) NOT NULL DEFAULT 0,
  `code` int(2) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `actief` int(1) NOT NULL DEFAULT 0,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `fb_type`
--

INSERT INTO `fb_type` (`id`, `code`, `naam`, `actief`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
(1, 0, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(2, 1, 'Aantal', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(3, 2, 'Getal', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(4, 3, 'Tekstregel', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(5, 4, 'Tekstvak', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(6, 5, 'Keuze Ja/Nee', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(7, 6, 'Keuze één optie (radio)', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(8, 7, 'Keuze meerdere opties', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(9, 8, 'Koptekst', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(10, 9, 'Vaste tekst', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(11, 10, 'Akkoord', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(12, 11, 'Voorwaarde', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(13, 12, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(14, 13, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(15, 14, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(16, 15, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

--
-- Tabelstructuur voor tabel `fb_categorie`
--

CREATE TABLE `fb_categorie` (
  `id` int(11) NOT NULL DEFAULT 0,
  `code` int(2) NOT NULL DEFAULT 0,
  `naam` varchar(255) NOT NULL DEFAULT '',
  `actief` int(1) NOT NULL DEFAULT 0,
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `fb_categorie`
--

INSERT INTO `fb_categorie` (`id`, `code`, `naam`, `actief`, `gemaakt_datum`, `gemaakt_door`, `gewijzigd_datum`, `gewijzigd_door`) VALUES
(1, 0, '', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(2, 1, 'Wandeltocht', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(3, 2, 'Muziekles', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(4, 3, 'Yoga cursus', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(5, 4, 'Sportwedstrijd', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(6, 5, 'Tentoonstelling', 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(7, 6, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(8, 7, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(9, 8, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(10, 9, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(11, 10, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(121, 11, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(13, 12, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(14, 13, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(15, 14, 'Gereserveerd', 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

--
-- Tabelstructuur voor tabel `fb_wachtwoord_reset`
--

CREATE TABLE `fb_wachtwoord_reset` (
  `id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL DEFAULT 0,
  `token` varchar(255) NOT NULL DEFAULT '',
  `geldig_tot` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gemaakt_door` varchar(255) NOT NULL DEFAULT '',
  `gewijzigd_datum` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gewijzigd_door` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `fb_annuleringsverzekering`
--
ALTER TABLE `fb_annuleringsverzekering`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `fb_betaalwijze`
--
ALTER TABLE `fb_betaalwijze`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `fb_deelnemer`
--
ALTER TABLE `fb_deelnemer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_deelnemer_persoon1` (`persoon_id`),
  ADD KEY `fk_deelnemer_inschrijving1` (`inschrijving_id`);

--
-- Indexen voor tabel `fb_deelnemer_heeft_optie`
--
ALTER TABLE `fb_deelnemer_heeft_optie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gekozen_optie_optie10` (`optie_id`),
  ADD KEY `fk_deelnemer_optie_deelnemer1` (`deelnemer_id`);

--
-- Indexen voor tabel `fb_evenement`
--
ALTER TABLE `fb_evenement`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `fb_evenement_heeft_optie`
--
ALTER TABLE `fb_evenement_heeft_optie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gekozen_optie_optie1` (`optie_id`),
  ADD KEY `fk_evenement_optie_deelnemer1` (`evenement_id`),
  ADD UNIQUE (`evenement_id`, `optie_id`);

--
-- Indexen voor tabel `fb_factuur`
--
ALTER TABLE `fb_factuur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE (`factuurnummer`);

--
-- Indexen voor tabel `fb_gebruiker`
--
ALTER TABLE `fb_gebruiker`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_userid` (`userid`);

--
-- Indexen voor tabel `fb_inschrijving`
--
ALTER TABLE `fb_inschrijving`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_inschrijving_evenement1` (`evenement_id`);

--
-- Indexen voor tabel `fb_inschrijving_heeft_optie`
--
ALTER TABLE `fb_inschrijving_heeft_optie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gekozen_optie_optie1` (`optie_id`),
  ADD KEY `fk_inschrijving_optie_inschrijving1` (`inschrijving_id`);

--
-- Indexen voor tabel `fb_mailinglist`
--
ALTER TABLE `fb_mailinglist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mailing_evenement` (`evenement_id`);

--
-- Indexen voor tabel `fb_voucher`
--
ALTER TABLE `fb_voucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_voucher_code` (`code`);

--
-- Indexen voor tabel `fb_categorie`
--
ALTER TABLE `fb_categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categorie_code` (`code`);

--
-- Indexen voor tabel `fb_keuzes`
--
ALTER TABLE `fb_keuzes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_type_code` (`keuzetype`,`code`);

--
-- Indexen voor tabel `fb_contactlog``
--
ALTER TABLE `fb_contactlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contactlog_user` (`persoon_id`);

--
-- Indexen voor tabel `fb_optie`
--
ALTER TABLE `fb_optie`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `fb_persoon`
--
ALTER TABLE `fb_persoon`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `fb_type`
--
ALTER TABLE `fb_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_type_code` (`code`);

--
-- Indexen voor tabel `fb_wachtwoord_reset`
--
ALTER TABLE `fb_wachtwoord_reset`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `fb_annuleringsverzekering`
--
ALTER TABLE `fb_annuleringsverzekering`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_betaalwijze`
--
ALTER TABLE `fb_betaalwijze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_deelnemer`
--
ALTER TABLE `fb_deelnemer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_deelnemer_heeft_optie`
--
ALTER TABLE `fb_deelnemer_heeft_optie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_evenement_heeft_optie`
--
ALTER TABLE `fb_evenement_heeft_optie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
--
-- AUTO_INCREMENT voor een tabel `fb_evenement`
--
ALTER TABLE `fb_evenement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21001;

--
-- AUTO_INCREMENT voor een tabel `fb_factuur`
--
ALTER TABLE `fb_factuur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
--
-- AUTO_INCREMENT voor een tabel `fb_gebruiker`
--
ALTER TABLE `fb_gebruiker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_inschrijving`
--
ALTER TABLE `fb_inschrijving`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21001;

--
-- AUTO_INCREMENT voor een tabel `fb_inschrijving_heeft_optie`
--
ALTER TABLE `fb_inschrijving_heeft_optie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_keuzes`
--
ALTER TABLE `fb_keuzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_keuzes`
--
ALTER TABLE `fb_contactlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_mailinglist``
--
ALTER TABLE `fb_mailinglist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21001;

--
-- AUTO_INCREMENT voor een tabel `fb_optie`
--
ALTER TABLE `fb_optie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_persoon`
--
ALTER TABLE `fb_persoon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_type`
--
ALTER TABLE `fb_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_voucher`
--
ALTER TABLE `fb_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_categorie`
--
ALTER TABLE `fb_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `fb_wachtwoord_reset`
--
ALTER TABLE `fb_wachtwoord_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `fb_deelnemer`
--
ALTER TABLE `fb_deelnemer`
  ADD CONSTRAINT `fk_deelnemer_inschrijving1` FOREIGN KEY (`inschrijving_id`) REFERENCES `fb_inschrijving` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_deelnemer_persoon1` FOREIGN KEY (`persoon_id`) REFERENCES `fb_persoon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_deelnemer_heeft_optie`
--
ALTER TABLE `fb_deelnemer_heeft_optie`
  ADD CONSTRAINT `fk_deelnemer_optie_deelnemer1` FOREIGN KEY (`deelnemer_id`) REFERENCES `fb_deelnemer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_gekozen_optie_optie10` FOREIGN KEY (`optie_id`) REFERENCES `fb_optie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_evenement`
--
ALTER TABLE `fb_evenement`
--  ADD CONSTRAINT `fk_evenement_keuzes` FOREIGN KEY (`status`) REFERENCES `fb_keuzes` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenement_categorie` FOREIGN KEY (`categorie`) REFERENCES `fb_categorie` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_evenement_heeft_optie`
--
ALTER TABLE `fb_evenement_heeft_optie`
  ADD CONSTRAINT `fk_evenement_has_optie_evenement1` FOREIGN KEY (`evenement_id`) REFERENCES `fb_evenement` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evenement_has_optie_optie1` FOREIGN KEY (`optie_id`) REFERENCES `fb_optie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_factuur`
--
ALTER TABLE `fb_factuur`
  ADD CONSTRAINT `fk_inschrijving_factuur` FOREIGN KEY (`inschrijving_id`) REFERENCES `fb_inschrijving` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_gebruiker`
--
-- ALTER TABLE `fb_gebruiker`
--  ADD CONSTRAINT `fk_gebruiker_keuzes` FOREIGN KEY (`rol`) REFERENCES `fb_keuzes` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_contactlog`
--
ALTER TABLE `fb_contactlog`
  ADD CONSTRAINT `fk_gebruiker_log` FOREIGN KEY (`persoon_id`) REFERENCES `fb_persoon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_inschrijving`
--
ALTER TABLE `fb_inschrijving`
  ADD CONSTRAINT `fk_inschrijving_evenement1` FOREIGN KEY (`evenement_id`) REFERENCES `fb_evenement` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
--  ADD CONSTRAINT `fk_inschrijving_keuzes` FOREIGN KEY (`status`) REFERENCES `fb_keuzes` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inschrijving_contactpersoon` FOREIGN KEY (`contactpersoon_id`) REFERENCES `fb_persoon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_inschrijving_heeft_optie`
--
ALTER TABLE `fb_inschrijving_heeft_optie`
  ADD CONSTRAINT `fk_gekozen_optie_optie1` FOREIGN KEY (`optie_id`) REFERENCES `fb_optie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inschrijving_optie_inschrijving1` FOREIGN KEY (`inschrijving_id`) REFERENCES `fb_inschrijving` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_mailinglist`
--
ALTER TABLE `fb_mailinglist`
  ADD CONSTRAINT `fk_mailing_evenement` FOREIGN KEY (`evenement_id`) REFERENCES `fb_evenement` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_optie`
--
ALTER TABLE `fb_optie`
--  ADD CONSTRAINT `fk_optie_keuzes` FOREIGN KEY (`status`) REFERENCES `fb_keuzes` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_optie_type` FOREIGN KEY (`optietype`) REFERENCES `fb_type` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_wachtwoord_reset`
--
ALTER TABLE `fb_wachtwoord_reset`
  ADD CONSTRAINT `fk_gebruiker_wachtwoord` FOREIGN KEY (`email`) REFERENCES `fb_gebruiker` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `fb_voucher`
--
ALTER TABLE `fb_voucher`
  ADD CONSTRAINT `fk_evenement_voucher` FOREIGN KEY (`evenement_id`) REFERENCES `fb_evenement` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
