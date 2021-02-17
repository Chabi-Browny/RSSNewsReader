-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Feb 17. 12:07
-- Kiszolgáló verziója: 10.4.13-MariaDB
-- PHP verzió: 7.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `rss_feed_db`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rss_infos`
--

CREATE TABLE `rss_infos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `link` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- A tábla adatainak kiíratása `rss_infos`
--

INSERT INTO `rss_infos` (`id`, `user_id`, `name`, `link`) VALUES
(1, 1, 'prohardver', 'https://prohardver.hu/hirfolyam/hirek/rss.xml'),
(14, 32, 'PC World Online Hírek', 'https://pcworld.hu/site/rss/rss.xml'),
(15, 1, 'Prog.Hu RSS', 'https://prog.hu/site/backend/proghu-rss.xml'),
(18, 32, 'Prog.Hu RSS', 'https://prog.hu/site/backend/proghu-rss.xml');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `u_name` varchar(150) COLLATE utf8_bin NOT NULL,
  `u_pass` text COLLATE utf8_bin NOT NULL,
  `u_email` varchar(150) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `u_name`, `u_pass`, `u_email`) VALUES
(1, 'user', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', 'home@home.hu'),
(32, 'pista', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', '');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `rss_infos`
--
ALTER TABLE `rss_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_connect` (`user_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `rss_infos`
--
ALTER TABLE `rss_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `rss_infos`
--
ALTER TABLE `rss_infos`
  ADD CONSTRAINT `user_connect` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
