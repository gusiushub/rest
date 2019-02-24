-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 24 2019 г., 17:21
-- Версия сервера: 5.6.41
-- Версия PHP: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `name` text NOT NULL,
  `new_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `avatars`
--

INSERT INTO `avatars` (`id`, `name`, `new_path`) VALUES
(1, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/001.jpg'),
(2, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/002.jpg'),
(3, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/003.jpg'),
(4, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/004.jpg'),
(5, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/005.jpg'),
(6, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/006.jpg'),
(7, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/007.jpg'),
(8, 'Animals___Wild_cats_Moody_tiger_076162_ - ', './../app/img/a/000/008.jpg'),
(9, 'Animals___Wild_cats_Moody_tiger_076162_.jpg', './../app/img/a/000/009.jpg'),
(10, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/010.jpg'),
(11, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/011.jpg'),
(12, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/012.jpg'),
(13, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/013.jpg'),
(14, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/014.jpg'),
(15, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/015.jpg'),
(16, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/016.jpg'),
(17, 'Movies_Chameleon_Rango_from_the_movie_064247_ - ', './../app/img/a/000/017.jpg'),
(18, 'Movies_Chameleon_Rango_from_the_movie_064247_.jpg', './../app/img/a/000/018.jpg');

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
(1, '2019-02-06 00:00:00', 'admin', 'admin', '1111111', '11.122.323.22', 'russia', 1, 18, 'sdfsdfsdf sdfsdfsdf', 'sdfsdfsdfsdfsdf', '', 0, 0, 0, 0),
(2, '2019-02-06 00:00:00', 'admin', 'admin', '1111111', '11.122.323.22', 'russia', 1, 18, 'sdfsdfsdf sdfsdfsdf', 'sdfsdfsdfsdfsdf', '', 0, 0, 0, 0),
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
(19, '0000-00-00 00:00:00', 'adasas', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', '', 0, 0, 0, 0),
(45, '0000-00-00 00:00:00', 'jjjjjjj', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/000.jpg', 0, 0, 0, 0),
(46, '0000-00-00 00:00:00', 'sdsdfsdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/001.jpg', 0, 0, 0, 0),
(47, '2019-02-22 09:30:32', 'sdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/002.jpg', 0, 0, 0, 0),
(48, '2019-02-22 09:43:04', 'sdasdasdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/003.jpg', 0, 0, 0, 0),
(49, '2019-02-22 09:44:19', 'sdfsdfsdf', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/004.jpg', 0, 0, 0, 0),
(50, '2019-02-22 09:51:21', 'fhfghfghfghfhfgh', 'oooooo', '1234', '29.292.92', 'rus', 1, 22, 'nikita', '', 'a/000/005.jpg', 0, 0, 0, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
