-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/12/2024 às 03:48
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_iot`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbl_dc`
--

CREATE TABLE `tbl_dc` (
  `id` int(11) NOT NULL,
  `data` varchar(12) NOT NULL,
  `hora` varchar(9) NOT NULL,
  `temp` varchar(5) NOT NULL,
  `umidade` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbl_dc`
--

INSERT INTO `tbl_dc` (`id`, `data`, `hora`, `temp`, `umidade`) VALUES
(7, '7/12/2024', '17:58:14', '29.8', '55'),
(8, '7/12/2024', '18:08:52', '29.4', '58'),
(9, '7/12/2024', '18:09:06', '29.4', '59'),
(10, '7/12/2024', '20:08:04', '28.8', '65');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbl_dc`
--
ALTER TABLE `tbl_dc`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbl_dc`
--
ALTER TABLE `tbl_dc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
