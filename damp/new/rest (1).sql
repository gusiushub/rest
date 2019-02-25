-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 25 2019 г., 07:39
-- Версия сервера: 5.6.34-log
-- Версия PHP: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `rest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `avatars`
--

CREATE TABLE `avatars` (
  `id` int(11) NOT NULL,
  `old_name` text NOT NULL,
  `new_path` text NOT NULL,
  `old_path` text NOT NULL,
  `flag` int(11) NOT NULL,
  `new_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `avatars`
--

INSERT INTO `avatars` (`id`, `old_name`, `new_path`, `old_path`, `flag`, `new_name`) VALUES
(1, '045.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/113.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/045.jpg', 0, '113.jpg'),
(2, '046.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/114.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/046.jpg', 0, '114.jpg'),
(3, '047.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/115.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/047.jpg', 0, '115.jpg'),
(4, '048.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/116.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/048.jpg', 0, '116.jpg'),
(5, '049.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/117.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/049.jpg', 0, '117.jpg'),
(6, '050.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/118.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/050.jpg', 0, '118.jpg'),
(7, '051.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/119.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/051.jpg', 0, '119.jpg'),
(8, '052.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/120.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/052.jpg', 0, '120.jpg'),
(9, '053.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/121.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/053.jpg', 0, '121.jpg'),
(10, '054.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/122.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/054.jpg', 0, '122.jpg'),
(11, '055.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/123.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/055.jpg', 0, '123.jpg'),
(12, '056.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/124.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/056.jpg', 0, '124.jpg'),
(13, '057.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/125.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/057.jpg', 0, '125.jpg'),
(14, '058.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/126.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/058.jpg', 0, '126.jpg'),
(15, '059.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/127.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/059.jpg', 0, '127.jpg'),
(16, '060.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/128.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/060.jpg', 0, '128.jpg'),
(17, '061.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/129.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/061.jpg', 0, '129.jpg'),
(18, '062.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/130.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/062.jpg', 0, '130.jpg'),
(19, '063.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/131.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/063.jpg', 0, '131.jpg'),
(20, '064.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/132.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/064.jpg', 0, '132.jpg'),
(21, '065.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/133.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/065.jpg', 0, '133.jpg'),
(22, '066.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/134.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/066.jpg', 0, '134.jpg'),
(23, '067.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/135.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/067.jpg', 0, '135.jpg'),
(24, '068.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/136.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/068.jpg', 0, '136.jpg'),
(25, '069.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/137.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/069.jpg', 0, '137.jpg'),
(26, '070.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/138.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/070.jpg', 0, '138.jpg'),
(27, '071.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/139.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/071.jpg', 0, '139.jpg'),
(28, '072.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/140.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/072.jpg', 0, '140.jpg'),
(29, '073.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/141.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/073.jpg', 0, '141.jpg'),
(30, '074.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/142.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/074.jpg', 0, '142.jpg'),
(31, '075.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/143.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/075.jpg', 0, '143.jpg'),
(32, '076.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/144.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/076.jpg', 0, '144.jpg'),
(33, '077.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/145.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/077.jpg', 0, '145.jpg'),
(34, '078.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/146.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/078.jpg', 0, '146.jpg'),
(35, '079.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/147.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/079.jpg', 0, '147.jpg'),
(36, '080.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/148.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/080.jpg', 0, '148.jpg'),
(37, '081.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/149.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/081.jpg', 0, '149.jpg'),
(38, '082.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/150.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/082.jpg', 0, '150.jpg'),
(39, '083.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/151.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/083.jpg', 0, '151.jpg'),
(40, '084.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/152.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/084.jpg', 0, '152.jpg'),
(41, '085.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/153.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/085.jpg', 0, '153.jpg'),
(42, '086.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/154.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/086.jpg', 0, '154.jpg'),
(43, '087.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/155.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/087.jpg', 0, '155.jpg'),
(44, '088.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/156.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/088.jpg', 0, '156.jpg'),
(45, '089.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/157.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/089.jpg', 0, '157.jpg'),
(46, '090.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/158.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/090.jpg', 0, '158.jpg'),
(47, '091.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/159.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/091.jpg', 0, '159.jpg'),
(48, '092.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/160.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/092.jpg', 0, '160.jpg'),
(49, '093.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/161.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/093.jpg', 0, '161.jpg'),
(50, '094.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/162.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/094.jpg', 0, '162.jpg'),
(51, '095.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/163.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/095.jpg', 0, '163.jpg'),
(52, '096.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/164.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/096.jpg', 0, '164.jpg'),
(53, '097.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/165.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/097.jpg', 0, '165.jpg'),
(54, '098.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/166.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/098.jpg', 0, '166.jpg'),
(55, '099.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/167.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/099.jpg', 0, '167.jpg'),
(56, '100.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/168.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/100.jpg', 0, '168.jpg'),
(57, '101.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/169.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/101.jpg', 0, '169.jpg'),
(58, '102.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/170.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/102.jpg', 0, '170.jpg'),
(59, '103.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/171.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/103.jpg', 0, '171.jpg'),
(60, '104.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/172.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/104.jpg', 0, '172.jpg'),
(61, '105.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/173.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/105.jpg', 0, '173.jpg'),
(62, '106.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/174.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/106.jpg', 0, '174.jpg'),
(63, '107.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/175.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/107.jpg', 0, '175.jpg'),
(64, '108.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/176.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/108.jpg', 0, '176.jpg'),
(65, '109.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/177.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/109.jpg', 0, '177.jpg'),
(66, '110.jpg', 'C:openServerOpenServerdomains\restappconfig/../img/a/000/178.jpg', 'C:openServerOpenServerdomains\restappconfig/../../incoming/110.jpg', 0, '178.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Date` datetime NOT NULL,
  `Login` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Sex` int(1) NOT NULL,
  `Age` int(2) NOT NULL,
  `Fullname` varchar(50) NOT NULL,
  `Bio` text NOT NULL,
  `Profilepicture` varchar(20) NOT NULL,
  `Interrests` int(3) NOT NULL,
  `Postcount` int(5) NOT NULL,
  `Quality` int(2) NOT NULL,
  `Status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `Date`, `Login`, `Password`, `Phone`, `ip`, `Country`, `Sex`, `Age`, `Fullname`, `Bio`, `Profilepicture`, `Interrests`, `Postcount`, `Quality`, `Status`) VALUES
(1, '2019-02-06 00:00:00', 'admin', 'admin', '1111111', '11.122.323.22', 'russia', 1, 18, 'sdfsdfsdf sdfsdfsdf', 'sdfsdfsdfsdfsdf', '', 0, 0, 0, 1),
(2, '2019-02-06 00:00:00', 'admin', 'admin', '1111111', '11.122.323.22', 'russia', 1, 18, 'sdfsdfsdf sdfsdfsdf', 'sdfsdfsdfsdfsdf', '', 0, 0, 0, 1),
(3, '0000-00-00 00:00:00', '', '', '', '', '', 0, 0, '', '', '', 0, 0, 0, 0),
(4, '0000-00-00 00:00:00', 'ooooo', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(5, '0000-00-00 00:00:00', 'oogggooo', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(6, '0000-00-00 00:00:00', 'oogffggooo', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(7, '0000-00-00 00:00:00', 'dd', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(8, '0000-00-00 00:00:00', 'ggg', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(9, '0000-00-00 00:00:00', 'ddddd', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(10, '0000-00-00 00:00:00', 'rrrrr', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(11, '0000-00-00 00:00:00', 'vvvvv', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(12, '0000-00-00 00:00:00', 'bbbb', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(13, '0000-00-00 00:00:00', 'ccccccc', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(14, '0000-00-00 00:00:00', 'aaaa', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(15, '0000-00-00 00:00:00', 'ffff', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(16, '0000-00-00 00:00:00', 'ccccc', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(17, '0000-00-00 00:00:00', 'ffffd', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(18, '0000-00-00 00:00:00', 'sdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(52, '2019-02-22 10:20:15', 'sdfsdfsdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/000.jpg', 0, 0, 0, 0),
(53, '2019-02-22 10:20:51', 'asdasd', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/001.jpg', 0, 0, 0, 0),
(54, '2019-02-22 10:51:14', 'sdfsdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/002.jpg', 0, 0, 0, 0),
(55, '2019-02-22 10:51:58', 'ssdfsdfsdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/003.jpg', 0, 0, 0, 1),
(56, '2019-02-22 12:24:09', 'sdfsdfsdfsdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/004.jpg', 0, 0, 0, 0),
(57, '2019-02-25 01:59:15', 'dsfdfdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/005.jpg', 0, 0, 0, 0),
(58, '2019-02-25 01:59:37', 'sdsssddddss', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/006.jpg', 0, 0, 0, 0),
(59, '2019-02-25 02:07:57', 'sdfsdfsdsss', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/007.jpg', 0, 0, 0, 0),
(60, '2019-02-25 02:21:07', 'sdfsddvccbffds', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/008.jpg', 0, 0, 0, 0),
(61, '2019-02-25 02:23:42', 'sdfsdddvvbfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/009.jpg', 0, 0, 0, 0),
(62, '2019-02-25 02:26:06', 'ggggkllpp', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/010.jpg', 0, 0, 0, 0),
(63, '2019-02-25 04:51:58', 'ddddfffsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/011.jpg', 0, 0, 0, 0),
(64, '2019-02-25 07:12:06', 'adazxv', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/012.jpg', 0, 0, 0, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `avatars`
--
ALTER TABLE `avatars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
