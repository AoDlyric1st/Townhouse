-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 05 2026 г., 05:14
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
-- База данных: `realestate`
--

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE `client` (
  `Id` int(11) NOT NULL,
  `SecondName` varchar(60) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `Patronym` varchar(60) NOT NULL,
  `Phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`Id`, `SecondName`, `FirstName`, `Patronym`, `Phone`) VALUES
(1, 'Сидоров', 'Алексей', 'Петрович', '+7(999)777-88-99'),
(2, 'Кузнецова', 'Мария', 'Игоревна', '+7(999)000-11-22');

-- --------------------------------------------------------

--
-- Структура таблицы `house`
--

CREATE TABLE `house` (
  `Id` int(11) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Floors` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Location_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `house`
--

INSERT INTO `house` (`Id`, `Address`, `Floors`, `Price`, `Location_Id`) VALUES
(1, 'ул. Южная, д. 1', 1, '5000000.00', 1),
(2, 'ул. Южная, д. 2', 2, '7500000.00', 1),
(3, 'ул. Северная, д. 10', 3, '12000000.00', 2),
(4, 'ул. Западная, д. 5', 1, '4500000.00', 3),
(5, 'ул. Восточная, д. 8', 2, '8500000.00', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `location`
--

CREATE TABLE `location` (
  `Id` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `location`
--

INSERT INTO `location` (`Id`, `Name`) VALUES
(1, 'Юг'),
(2, 'Север'),
(3, 'Запад'),
(4, 'Восток');

-- --------------------------------------------------------

--
-- Структура таблицы `realtor`
--

CREATE TABLE `realtor` (
  `Id` int(11) NOT NULL,
  `SecondName` varchar(60) NOT NULL,
  `FirstName` varchar(60) NOT NULL,
  `Patronym` varchar(60) NOT NULL,
  `Phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `realtor`
--

INSERT INTO `realtor` (`Id`, `SecondName`, `FirstName`, `Patronym`, `Phone`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', '+7(999)111-22-33'),
(2, 'Петрова', 'Анна', 'Сергеевна', '+7(999)444-55-66'),
(3, 'Соколова', 'Инна', 'Олеговна', '+7(999)256-13-59'),
(4, 'Агутина', 'Анастасия', 'Владимировна', '+7(999)124-78-90');

-- --------------------------------------------------------

--
-- Структура таблицы `sale`
--

CREATE TABLE `sale` (
  `Id` int(11) NOT NULL,
  `House_Id` int(11) NOT NULL,
  `Client_Id` int(11) NOT NULL,
  `Realtor_Id` int(11) NOT NULL,
  `SaleDate` date NOT NULL,
  `ContractNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `sale`
--

INSERT INTO `sale` (`Id`, `House_Id`, `Client_Id`, `Realtor_Id`, `SaleDate`, `ContractNumber`) VALUES
(1, 1, 1, 1, '2025-10-01', 'Д-001'),
(2, 3, 2, 2, '2023-10-15', 'Д-002'),
(3, 5, 1, 1, '2023-11-20', 'Д-003');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_house_location` (`Location_Id`);

--
-- Индексы таблицы `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `realtor`
--
ALTER TABLE `realtor`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_sale_house` (`House_Id`),
  ADD KEY `fk_sale_client` (`Client_Id`),
  ADD KEY `fk_sale_realtor` (`Realtor_Id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `client`
--
ALTER TABLE `client`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `house`
--
ALTER TABLE `house`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `location`
--
ALTER TABLE `location`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `realtor`
--
ALTER TABLE `realtor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `sale`
--
ALTER TABLE `sale`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `fk_house_location` FOREIGN KEY (`Location_Id`) REFERENCES `location` (`Id`);

--
-- Ограничения внешнего ключа таблицы `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `fk_sale_client` FOREIGN KEY (`Client_Id`) REFERENCES `client` (`Id`),
  ADD CONSTRAINT `fk_sale_house` FOREIGN KEY (`House_Id`) REFERENCES `house` (`Id`),
  ADD CONSTRAINT `fk_sale_realtor` FOREIGN KEY (`Realtor_Id`) REFERENCES `realtor` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
