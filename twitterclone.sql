-- phpMyAdmin SQL Dump
-- versão corrigida para evitar erros de FK

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Banco de dados: `twitterclone`

-- Tabela `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_nascimento` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabela `tweets`
CREATE TABLE `tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabela `comentarios`
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tweet_id` (`tweet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabela `likes`
CREATE TABLE `likes` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tweet_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_like (tweet_id, user_id),
  KEY `tweet_id` (`tweet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Tabela `contatos`
CREATE TABLE `contatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `assunto` varchar(100) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Inserção de dados

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `cpf`, `data_nascimento`) VALUES
(1, 'João Pedro', 'joao@gmail.com', '$2y$10$GhnCz952mEfI.dOPK6BNu.nZs2dql5eSX4JYx1HFaUIB6QDic7l.O', '123.456.789-00', '2000-01-01'),
(2, 'Kauan Lima Ferreira', 'kauanlima@gmail.com', '$2y$10$kbWy2.2w.3WEYVKvPsuZautvLZ3F8IxjXdIhrCFEUkAv/pCHofV2i', '097.249.133-39', '2006-07-31');

INSERT INTO `tweets` (`id`, `user_id`, `texto`) VALUES
(1, 1, 'Primeiro tweet!'),
(2, 1, 'Salve!'),
(3, 2, 'Olá, que tal nos followarmos?');

INSERT INTO `comentarios` (`id`, `tweet_id`, `user_id`, `texto`) VALUES
(1, 2, 2, 'Olá!!'),
(2, 2, 1, 'Pois é!');

INSERT INTO `likes` (`id`, `tweet_id`, `user_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 1);

INSERT INTO `contatos` (`id`, `nome`, `email`, `assunto`, `mensagem`) VALUES
(1, 'Kauan Lima', 'kauanlima@gmail.com', 'Teste!', 'Testando V1');

-- Foreign Keys (após PKs e índices)

ALTER TABLE `tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;
