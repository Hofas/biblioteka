-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 01 Kwi 2019, 15:41
-- Wersja serwera: 10.1.36-MariaDB
-- Wersja PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `biblioteka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `author` text COLLATE utf8_polish_ci NOT NULL,
  `owner` int(11) NOT NULL,
  `label` tinytext COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `owner`, `label`) VALUES
(1, 'IT', 'Stefan King', 2, ''),
(2, 'Jak Się Uczyć', 'Ron Fry', 2, ''),
(3, 'Pielgrzym', 'Terry Hayes', 2, ''),
(4, 'Słynne Ucieczki Polaków', 'Andrzej Fedorowicz', 2, ''),
(5, 'Legion', 'Elżbieta Cherezińska', 2, ''),
(6, 'W ogrodzie Bestii', 'Erik Larson', 2, ''),
(22, 'Pan Kleks', 'Jan Brzechwa', 2, ''),
(60, 'wielkie żarcie', 'kogoś tam', 2, ''),
(61, 'Przygody Tomka Soyera', 'nieznany', 3, ''),
(62, 'Jak rozętałem II woj sw', 'adam Psikutas', 3, ''),
(63, 'E.14 - Egzamin bez granic', 'Bezi', 4, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `mail` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `imie`, `nazwisko`, `mail`, `pass`) VALUES
(2, 'jdm', 'paweł', 'hofman', 'pawel.hofman@selgros.pl', '$2y$10$OM6VL98iWE7GGk4HB9wfQeyBDRR75Vjm7.lZdwo9thtODd2rpvm9m'),
(3, 'jasiu', 'jasiu', 'nowak', 'jasiu@wp.pl', '$2y$10$dkpk/8o0ySNi/kCv1nYjaefBuwwfdbTH.nnxzHYsLKYrwAcCEi7E.'),
(4, 'LWJGL', 'Szymon', 'Wrzos', 'szwrzos@onet.pl', '$2y$10$IvRfL3mnHCBqX6gstuy.quvAgYbsldWqf7Lb9oLw7vu2ymBEIU.Ci'),
(5, 'alamakota', 'Ala', 'Makota', 'any@gmail.com', '$2y$10$yL1UhZzAoggrEX6mWircfeXtZdivRnZLS2YyKXXH4w/rmwNz6r9Mq');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
