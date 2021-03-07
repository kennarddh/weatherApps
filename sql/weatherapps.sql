-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2021 at 05:12 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weatherapps`
--

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE `weather` (
  `id` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `expire` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weather`
--

INSERT INTO `weather` (`id`, `city`, `data`, `expire`) VALUES
(1, 'Jakarta', '{\r\n    \"request\": {\r\n        \"type\": \"City\",\r\n        \"query\": \"Kabul, Afghanistan\",\r\n        \"language\": \"en\",\r\n        \"unit\": \"m\"\r\n    },\r\n    \"location\": {\r\n        \"name\": \"Kabul\",\r\n        \"country\": \"Afghanistan\",\r\n        \"region\": \"Kabol\",\r\n        \"lat\": \"34.517\",\r\n        \"lon\": \"69.183\",\r\n        \"timezone_id\": \"Asia/Kabul\",\r\n        \"localtime\": \"2021-03-07 07:56\",\r\n        \"localtime_epoch\": 1615103760,\r\n        \"utc_offset\": \"4.50\"\r\n    },\r\n    \"current\": {\r\n        \"observation_time\": \"03:26 AM\",\r\n        \"temperature\": 4,\r\n        \"weather_code\": 143,\r\n        \"weather_icons\": [\r\n            \"https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0006_mist.png\"\r\n        ],\r\n        \"weather_descriptions\": [\r\n            \"Mist\"\r\n        ],\r\n        \"wind_speed\": 0,\r\n        \"wind_degree\": 355,\r\n        \"wind_dir\": \"N\",\r\n        \"pressure\": 1018,\r\n        \"precip\": 0.7,\r\n        \"humidity\": 93,\r\n        \"cloudcover\": 100,\r\n        \"feelslike\": 3,\r\n        \"uv_index\": 1,\r\n        \"visibility\": 5,\r\n        \"is_day\": \"yes\"\r\n    }\r\n}', 10986542),
(2, 'Jakarta', '{\"request\":{\"type\":\"City\",\"query\":\"Jakarta, Indonesia\",\"language\":\"en\",\"unit\":\"m\"},\"location\":{\"name\":\"Jakarta\",\"country\":\"Indonesia\",\"region\":\"Jakarta Raya\",\"lat\":\"-6.215\",\"lon\":\"106.845\",\"timezone_id\":\"Asia/Jakarta\",\"localtime\":\"2021-03-07 11:02\",\"localtime_epoch\":1615114920,\"utc_offset\":\"7.0\"},\"current\":{\"observation_time\":\"04:02 AM\",\"temperature\":29,\"weather_code\":176,\"weather_icons\":[\"https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0009_light_rain_showers.png\"],\"weather_descriptions\":[\"Patchy rain possible\"],\"wind_speed\":5,\"wind_degree\":196,\"wind_dir\":\"SSW\",\"pressure\":1012,\"precip\":2.2,\"humidity\":64,\"cloudcover\":60,\"feelslike\":32,\"uv_index\":6,\"visibility\":8,\"is_day\":\"yes\"}}', 1615111343),
(3, 'Harare', '{\"request\":{\"type\":\"City\",\"query\":\"Harare, Zimbabwe\",\"language\":\"en\",\"unit\":\"m\"},\"location\":{\"name\":\"Harare\",\"country\":\"Zimbabwe\",\"region\":\"Mashonaland East\",\"lat\":\"-17.818\",\"lon\":\"31.045\",\"timezone_id\":\"Africa/Harare\",\"localtime\":\"2021-03-07 06:03\",\"localtime_epoch\":1615096980,\"utc_offset\":\"2.0\"},\"current\":{\"observation_time\":\"04:03 AM\",\"temperature\":15,\"weather_code\":116,\"weather_icons\":[\"https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0004_black_low_cloud.png\"],\"weather_descriptions\":[\"Partly cloudy\"],\"wind_speed\":10,\"wind_degree\":141,\"wind_dir\":\"SE\",\"pressure\":1015,\"precip\":0,\"humidity\":94,\"cloudcover\":60,\"feelslike\":15,\"uv_index\":1,\"visibility\":5,\"is_day\":\"yes\"}}', 1615111398),
(4, 'Harare', '{\"request\":{\"type\":\"City\",\"query\":\"Harare, Zimbabwe\",\"language\":\"en\",\"unit\":\"m\"},\"location\":{\"name\":\"Harare\",\"country\":\"Zimbabwe\",\"region\":\"Mashonaland East\",\"lat\":\"-17.818\",\"lon\":\"31.045\",\"timezone_id\":\"Africa/Harare\",\"localtime\":\"2021-03-07 06:11\",\"localtime_epoch\":1615097460,\"utc_offset\":\"2.0\"},\"current\":{\"observation_time\":\"04:11 AM\",\"temperature\":15,\"weather_code\":116,\"weather_icons\":[\"https://assets.weatherstack.com/images/wsymbols01_png_64/wsymbol_0004_black_low_cloud.png\"],\"weather_descriptions\":[\"Partly cloudy\"],\"wind_speed\":10,\"wind_degree\":141,\"wind_dir\":\"SE\",\"pressure\":1015,\"precip\":0,\"humidity\":94,\"cloudcover\":60,\"feelslike\":15,\"uv_index\":1,\"visibility\":5,\"is_day\":\"yes\"}}', 1615111914);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weather`
--
ALTER TABLE `weather`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
