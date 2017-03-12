-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Şub 2017, 23:13:43
-- Sunucu sürümü: 5.7.14
-- PHP Sürümü: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yoklama`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `beacon`
--

CREATE TABLE `beacon` (
  `beacon_id` int(10) NOT NULL,
  `beacon_uuid` varchar(100) COLLATE ucs2_turkish_ci NOT NULL,
  `beacon_major` int(10) NOT NULL,
  `beacon_minor` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 COLLATE=ucs2_turkish_ci;

--
-- Tablo döküm verisi `beacon`
--

INSERT INTO `beacon` (`beacon_id`, `beacon_uuid`, `beacon_major`, `beacon_minor`) VALUES
(1, '538c5ab2-4dba-43ba-53be-4eb041ad41b0', 153, 5),
(2, '538c5ab2-4dba-43ba-53be-4eb041ad41b0', 153, 2),
(3, '538c5ab2-4dba-43ba-53be-4eb041ad41b0', 1, 10),
(4, '538c5ab2-4dba-43ba-53be-4eb041ad41b0', 153, 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders`
--

CREATE TABLE `ders` (
  `ders_id` int(10) NOT NULL,
  `ders_adi` varchar(50) COLLATE ucs2_turkish_ci NOT NULL,
  `sinif_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 COLLATE=ucs2_turkish_ci;

--
-- Tablo döküm verisi `ders`
--

INSERT INTO `ders` (`ders_id`, `ders_adi`, `sinif_id`) VALUES
(1, 'Nesnelerin interneti', 1),
(2, 'Derleyici tasarimi', 2),
(3, 'Optimizasyon', 2),
(4, 'Mobil Uygulama Gelistirme ', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dersalir`
--

CREATE TABLE `dersalir` (
  `alir_id` int(5) NOT NULL,
  `ders_id` int(11) NOT NULL,
  `ogrenci_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=armscii8;

--
-- Tablo döküm verisi `dersalir`
--

INSERT INTO `dersalir` (`alir_id`, `ders_id`, `ogrenci_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 4, 1),
(4, 1, 2),
(5, 2, 2),
(6, 3, 2),
(7, 1, 3),
(8, 4, 3),
(9, 3, 3),
(10, 2, 4),
(11, 3, 4),
(12, 4, 4),
(13, 1, 5),
(14, 4, 5);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `derszaman`
--

CREATE TABLE `derszaman` (
  `derszaman_id` int(5) NOT NULL,
  `ders_id` int(11) NOT NULL,
  `zaman_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=armscii8;

--
-- Tablo döküm verisi `derszaman`
--

INSERT INTO `derszaman` (`derszaman_id`, `ders_id`, `zaman_id`) VALUES
(1, 1, 5),
(2, 1, 1),
(3, 2, 2),
(4, 2, 6),
(5, 3, 1),
(6, 3, 4),
(7, 4, 6),
(8, 4, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `imza`
--

CREATE TABLE `imza` (
  `imza_id` int(10) NOT NULL,
  `imza_tarihi` date DEFAULT NULL,
  `imza_saati` varchar(15) COLLATE ucs2_turkish_ci NOT NULL,
  `imza_ders` varchar(30) COLLATE ucs2_turkish_ci NOT NULL,
  `imza_adsoyadi` varchar(50) COLLATE ucs2_turkish_ci NOT NULL,
  `imza_numara` varchar(40) COLLATE ucs2_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 COLLATE=ucs2_turkish_ci;

--
-- Tablo döküm verisi `imza`
--

INSERT INTO `imza` (`imza_id`, `imza_tarihi`, `imza_saati`, `imza_ders`, `imza_adsoyadi`, `imza_numara`) VALUES
(1, '2017-01-28', '14:21', 'Nesnelerin Interneti', 'Fevzi Omur Tekin', 'b130910043'),
(2, '2017-02-01', '1:29', 'Nesnelerin Interneti', 'Fevzi Omur Tekin', 'b130910043'),
(3, '2017-02-01', '1:39', 'Nesnelerin Interneti', 'Fevzi Omur Tekin', 'b130910043'),
(4, '2017-02-01', '2:38', 'Nesnelerin Interneti', 'Fevzi Omur Tekin', 'b130910043'),
(5, '2017-02-01', '3:04', 'Nesnelerin Interneti', 'Fevzi Omur Tekin', 'b130910043'),
(6, '2017-02-01', '11:07', 'Nesnelerin Interneti', 'Fevzi Omur Tekin', 'b130910043'),
(7, '2017-02-01', '11:08', 'Optimizasyon', 'Mert Geyik ', 'B120910034 '),
(8, '2017-02-01', '11:15', 'Optimizasyon', 'Mert Geyik ', 'B120910034 '),
(9, '2017-02-01', '11:52', 'Nesnelerin interneti', 'Fevzi Omur Tekin ', 'B130910043 '),
(10, '2017-02-01', '12:15', 'Nesnelerin interneti', 'Fevzi Omur Tekin ', 'B130910043 '),
(16, '2017-02-01', '14:02', 'Derleyici tasarimi', 'Fevzi Omur Tekin ', 'B130910043 '),
(17, '2017-02-02', '10:51', 'Nesnelerin interneti', 'Fevzi Omur Tekin ', 'B130910043 '),
(18, '2017-02-02', '10:52', 'Nesnelerin interneti', 'Fatma Koc ', 'b120910028');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ogrenci`
--

CREATE TABLE `ogrenci` (
  `ogrenci_id` int(10) NOT NULL,
  `ogrenci_adisoyadi` varchar(50) COLLATE ucs2_turkish_ci NOT NULL,
  `ogrenci_numarasi` varchar(50) COLLATE ucs2_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 COLLATE=ucs2_turkish_ci;

--
-- Tablo döküm verisi `ogrenci`
--

INSERT INTO `ogrenci` (`ogrenci_id`, `ogrenci_adisoyadi`, `ogrenci_numarasi`) VALUES
(1, 'Fevzi Omur Tekin', 'b130910043'),
(2, 'Batuhan Talu', 'b130910028'),
(3, 'Fatma Koc', 'b120910028'),
(4, 'Mert Geyik', 'b120910034'),
(5, 'Muharrem Didici', 'b130910046');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sinif`
--

CREATE TABLE `sinif` (
  `sinif_id` int(10) NOT NULL,
  `sinif_adi` varchar(100) COLLATE ucs2_turkish_ci NOT NULL,
  `beacon_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 COLLATE=ucs2_turkish_ci;

--
-- Tablo döküm verisi `sinif`
--

INSERT INTO `sinif` (`sinif_id`, `sinif_adi`, `beacon_id`) VALUES
(1, '1103', 2),
(2, '1105', 4),
(3, '1107', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `zaman`
--

CREATE TABLE `zaman` (
  `zaman_id` int(11) NOT NULL,
  `tarih` date NOT NULL,
  `baslangicsaati` int(5) NOT NULL,
  `bitissaati` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=armscii8;

--
-- Tablo döküm verisi `zaman`
--

INSERT INTO `zaman` (`zaman_id`, `tarih`, `baslangicsaati`, `bitissaati`) VALUES
(1, '2017-02-03', 9, 12),
(2, '2017-02-03', 12, 15),
(3, '2017-02-03', 15, 18),
(4, '2017-02-03', 19, 22),
(5, '2017-03-04', 9, 12),
(6, '2017-02-04', 12, 15);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `beacon`
--
ALTER TABLE `beacon`
  ADD PRIMARY KEY (`beacon_id`);

--
-- Tablo için indeksler `ders`
--
ALTER TABLE `ders`
  ADD PRIMARY KEY (`ders_id`),
  ADD KEY `sinif_id` (`sinif_id`);

--
-- Tablo için indeksler `dersalir`
--
ALTER TABLE `dersalir`
  ADD PRIMARY KEY (`alir_id`),
  ADD KEY `ogrenci_id` (`ogrenci_id`),
  ADD KEY `ders_id` (`ders_id`);

--
-- Tablo için indeksler `derszaman`
--
ALTER TABLE `derszaman`
  ADD PRIMARY KEY (`derszaman_id`),
  ADD KEY `ders_id` (`ders_id`),
  ADD KEY `zaman_id` (`zaman_id`);

--
-- Tablo için indeksler `imza`
--
ALTER TABLE `imza`
  ADD PRIMARY KEY (`imza_id`);

--
-- Tablo için indeksler `ogrenci`
--
ALTER TABLE `ogrenci`
  ADD PRIMARY KEY (`ogrenci_id`);

--
-- Tablo için indeksler `sinif`
--
ALTER TABLE `sinif`
  ADD PRIMARY KEY (`sinif_id`),
  ADD UNIQUE KEY `beacon_id` (`beacon_id`);

--
-- Tablo için indeksler `zaman`
--
ALTER TABLE `zaman`
  ADD PRIMARY KEY (`zaman_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `beacon`
--
ALTER TABLE `beacon`
  MODIFY `beacon_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `ders`
--
ALTER TABLE `ders`
  MODIFY `ders_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Tablo için AUTO_INCREMENT değeri `dersalir`
--
ALTER TABLE `dersalir`
  MODIFY `alir_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Tablo için AUTO_INCREMENT değeri `derszaman`
--
ALTER TABLE `derszaman`
  MODIFY `derszaman_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Tablo için AUTO_INCREMENT değeri `imza`
--
ALTER TABLE `imza`
  MODIFY `imza_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Tablo için AUTO_INCREMENT değeri `ogrenci`
--
ALTER TABLE `ogrenci`
  MODIFY `ogrenci_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Tablo için AUTO_INCREMENT değeri `sinif`
--
ALTER TABLE `sinif`
  MODIFY `sinif_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Tablo için AUTO_INCREMENT değeri `zaman`
--
ALTER TABLE `zaman`
  MODIFY `zaman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
