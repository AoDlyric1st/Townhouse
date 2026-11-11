-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 05 2026 г., 05:17
-- Версия сервера: 5.6.43
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`) VALUES
(1, 'hth', '$2y$10$fuW0XiMHmYN2fOSzhY5e5.5lTRhfO0O94oAHroMY8NMHTtLAYrtJ2', 'hjg@mail.ru', NULL),
(2, 'lol', '$2y$10$CAQTHRY/pU73dG0fENcsvOyjw8zgeW91f1CDA.2PfhfHlBVpICL7C', 'lol@mail.ru', NULL),
(3, 'jo', '$2y$10$ui7vq5TWZD6CvBNSUZf6bO7nPkntZlxYB3B5aHWjmKBDTRIbavHve', 'jo@mail.ru', '88005553535'),
(4, 'dop', '$2y$10$jGlU5CFzl4Ge1igz9DMQTOejC2dVkbNhq4lhk6OhMw.PxFWLZ/q8.', 'dop@mail.ru', '88005553535'),
(5, 'pop', '$2y$10$sXa5ZIJYSmEwAmqrIKlz8.Ent.RhPUuxXkinRvln9YWcHsnxF/ajS', 'pop@mail.ru', '88005553535');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
