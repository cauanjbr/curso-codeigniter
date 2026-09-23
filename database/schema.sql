-- Estrutura do banco do projeto (MySQL/MariaDB do XAMPP).
-- Gerada a partir do banco local curso_ci_3 com mysqldump --no-data.
--
-- Uso: crie o banco e importe este arquivo pelo phpMyAdmin ou pelo terminal:
--   C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE curso_ci_3 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci"
--   C:\xampp\mysql\bin\mysql.exe -u root curso_ci_3 < database/schema.sql

CREATE TABLE IF NOT EXISTS `livros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `autor` varchar(150) DEFAULT NULL,
  `preco` decimal(15,2) DEFAULT NULL,
  `resumo` longtext DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuarios_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Primeiro acesso: o cadastro de usuários exige login, então sem este
-- registro não haveria como entrar num banco novo.
-- Login: admin@teste.com / senha: admin123 (troque em "Editar" depois de entrar).
INSERT IGNORE INTO `usuarios` (`nome`, `email`, `senha`, `ativo`) VALUES
  ('admin', 'admin@teste.com', '$2y$10$ooK6ZvSu93cO7hsp5y1I7e2DoRje7jfgP1S2lpIq3lgJh69i7bFEK', 1);
