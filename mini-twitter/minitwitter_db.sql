-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 17 Mar 2026, 09:05:48
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `minitwitter_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gonderiler`
--

CREATE TABLE `gonderiler` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `icerik` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `gonderiler`
--

INSERT INTO `gonderiler` (`id`, `kullanici_id`, `icerik`, `tarih`) VALUES
(1, 1, 'Bugün İran - İsrail - Abd üçgeninde neler yaşanacak.', '2026-03-17 07:43:49'),
(2, 2, 'Bugün havanın bu kadar sıcak olması normal mi ?', '2026-03-17 07:48:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `sifre`) VALUES
(1, 'binarycozum', '$2y$10$1EhZTwbtwWKLrCk8v1xXuuBbvnB1Eslp7FJCerjOcOokmtdhxK15C'),
(2, 'aslan01kral', '$2y$10$cR4y6xNyA1.YSDAqMu0teeRQkrlQIIoBOh0MHTPIrlnWCHwJRT6DO');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `gonderiler`
--
ALTER TABLE `gonderiler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `gonderiler`
--
ALTER TABLE `gonderiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
