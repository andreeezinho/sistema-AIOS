-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 12, 2025 at 01:55 AM
-- Server version: 9.2.0
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-03:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `documento` varchar(18) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os`
--

CREATE TABLE `os` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `clientes_id` int NOT NULL,
  `dispositivo` varchar(255) DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `desconto` int DEFAULT '0',
  `total` float(7,2) NOT NULL DEFAULT '0.00',
  `situacao` enum('cancelada','em andamento','concluida') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'em andamento',
  `usuarios_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os_servico`
--

CREATE TABLE `os_servico` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `os_id` int NOT NULL,
  `servicos_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissao_usuario`
--

CREATE TABLE `permissao_usuario` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `permissoes_id` int NOT NULL,
  `usuarios_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `permissao_usuario`
--

INSERT INTO `permissao_usuario` (`id`, `uuid`, `permissoes_id`, `usuarios_id`, `created_at`, `updated_at`) VALUES
(1, '961a9b16-6397-45fa-96cb-7d93454e88d2', 4, 1, '2025-03-02 00:31:09', '2025-03-02 00:31:09'),
(2, '001f1b13-4b1f-4b66-8058-ee1f74caf3ff', 1, 1, '2025-03-02 00:31:12', '2025-03-02 00:31:12'),
(3, 'c9c5b358-bd9a-4a74-89ef-7f9115a053d4', 2, 1, '2025-03-02 00:31:21', '2025-03-02 00:31:21'),
(4, 'a425c069-954a-44c9-a421-efad03105204', 3, 1, '2025-03-02 00:31:26', '2025-03-02 00:31:26'),
(5, 'edbf2b73-244f-4059-ad68-6328e82278e8', 8, 1, '2025-03-02 15:48:45', '2025-03-02 15:48:45'),
(6, '7967ac6c-95d1-437d-b92e-724a89e166ad', 7, 1, '2025-03-02 15:48:49', '2025-03-02 15:48:49'),
(7, '1a535440-f206-4037-9a5d-a6c72e5615da', 6, 1, '2025-03-02 15:48:56', '2025-03-02 15:48:56'),
(8, 'b2bb41cd-d878-4167-b287-587711951ce4', 5, 1, '2025-03-02 15:49:02', '2025-03-02 15:49:02'),
(17, '5dded4d0-152e-457c-9d61-7c2e0f07fb5a', 12, 1, '2025-03-06 23:45:40', '2025-03-06 23:45:40'),
(18, '5c4e4755-164e-41ab-9cbd-4efdef71f348', 11, 1, '2025-03-06 23:45:43', '2025-03-06 23:45:43'),
(19, '45ce0a19-4b99-4680-85f2-1705dcf766ad', 10, 1, '2025-03-06 23:45:46', '2025-03-06 23:45:46'),
(20, '6ca66ef5-b88d-4e55-acf4-27ee6f27921c', 9, 1, '2025-03-06 23:45:50', '2025-03-06 23:45:50'),
(21, 'add89b4d-f4cf-4300-ad72-4a67bc86cdc4', 16, 1, '2025-03-06 23:58:33', '2025-03-06 23:58:33'),
(22, '40315cf5-7a4f-499f-804c-283e6ff14203', 15, 1, '2025-03-06 23:58:35', '2025-03-06 23:58:35'),
(23, '8642fa0d-842a-4870-86d1-30b698b0a223', 14, 1, '2025-03-06 23:58:42', '2025-03-06 23:58:42'),
(24, '4646997c-bf4b-4595-866b-50ecdcfe6e6d', 13, 1, '2025-03-06 23:58:50', '2025-03-06 23:58:50'),
(25, 'babbdea4-4266-474e-ba84-d5e870e3fe5f', 20, 1, '2025-03-07 00:07:32', '2025-03-07 00:07:32'),
(26, '91ba46cc-e59e-4cbc-91a8-3f2493805393', 19, 1, '2025-03-07 00:07:39', '2025-03-07 00:07:39'),
(27, '5e1f8b1d-63df-4c8e-9e4d-0e7fd86c100b', 18, 1, '2025-03-07 00:07:43', '2025-03-07 00:07:43'),
(28, 'b2c82ad0-c7fd-4300-b28f-eb062fd9cc48', 17, 1, '2025-03-07 00:07:47', '2025-03-07 00:07:47'),
(29, '3bd878d6-aa8a-4d03-bbe1-e70548b42473', 24, 1, '2025-03-07 22:46:26', '2025-03-07 22:46:26'),
(30, 'd068b639-687a-411b-9074-0006750f269b', 23, 1, '2025-03-07 22:46:29', '2025-03-07 22:46:29'),
(31, '8d008920-672a-4847-8d51-5ab953bb9888', 22, 1, '2025-03-07 22:46:32', '2025-03-07 22:46:32'),
(32, '3e1297cf-65b2-483d-bef3-c614c1591ef2', 21, 1, '2025-03-07 22:46:37', '2025-03-07 22:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `permissoes`
--

CREATE TABLE `permissoes` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` enum('visualizar','cadastrar','editar','deletar') NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `permissoes`
--

INSERT INTO `permissoes` (`id`, `uuid`, `nome`, `tipo`, `ativo`, `created_at`, `updated_at`) VALUES
(1, '045147e0-e629-4fad-848b-907e1ea9862b', 'cadastrar usuarios', 'cadastrar', 1, '2025-03-02 00:30:26', '2025-03-02 00:30:26'),
(2, '7b46d38d-0ba3-49de-bb08-a2cd1a612b0a', 'editar usuarios', 'editar', 1, '2025-03-02 00:30:40', '2025-03-02 00:30:40'),
(3, '40756642-7cd7-4973-80c3-b68460fac6ff', 'deletar usuarios', 'deletar', 1, '2025-03-02 00:30:49', '2025-03-02 00:30:49'),
(4, '3ae4c1f1-1922-4daa-ba6a-8de2feea95a0', 'visualizar usuarios', 'visualizar', 1, '2025-03-02 00:30:57', '2025-03-02 00:30:57'),
(5, '0e61fed9-c42a-4afe-8ef5-0beab28245ea', 'visualizar clientes', 'visualizar', 1, '2025-03-02 15:48:03', '2025-03-02 15:48:03'),
(6, 'f441ee78-a9b0-4ec2-b47f-bfab1e846cf4', 'cadastrar clientes', 'cadastrar', 1, '2025-03-02 15:48:17', '2025-03-02 15:48:17'),
(7, '00ba4005-c55c-4d2c-8061-4652e29fc6f2', 'editar clientes', 'editar', 1, '2025-03-02 15:48:27', '2025-03-02 15:48:27'),
(8, '413bec56-f783-48b3-816c-ed31eb8f7fd9', 'deletar clientes', 'deletar', 1, '2025-03-02 15:48:35', '2025-03-02 15:48:35'),
(9, '494a1337-7a3b-47eb-89fb-5f97b16cba20', 'cadastrar os', 'cadastrar', 1, '2025-03-06 23:44:37', '2025-03-06 23:44:37'),
(10, '040e8d42-5b0d-457d-84e7-9fd514f43bed', 'editar os', 'editar', 1, '2025-03-06 23:44:45', '2025-03-06 23:44:45'),
(11, '344e41ac-a758-430f-b4ed-15395bc505e7', 'visualizar os', 'visualizar', 1, '2025-03-06 23:45:07', '2025-03-06 23:54:54'),
(12, '5a9ca52d-ff46-4359-9aa4-2e33a15445e0', 'deletar os', 'deletar', 1, '2025-03-06 23:45:15', '2025-03-06 23:45:15'),
(13, 'a4560218-7223-4a35-a4e2-7254a73cd50e', 'visualizar servicos', 'visualizar', 1, '2025-03-06 23:57:42', '2025-03-06 23:57:42'),
(14, '1e096beb-62f6-4048-9ee3-48b034572c69', 'cadastrar servicos', 'cadastrar', 1, '2025-03-06 23:57:53', '2025-03-06 23:57:53'),
(15, 'd1be6912-1299-485a-91f5-57d7c98b6881', 'editar servicos', 'editar', 1, '2025-03-06 23:58:06', '2025-03-06 23:58:06'),
(16, '0a1779b2-9ec5-4f9f-8a61-3dd3ae5e94df', 'deletar servicos', 'deletar', 1, '2025-03-06 23:58:16', '2025-03-06 23:58:16'),
(17, 'eecba816-4bec-41de-ae30-0973865a6314', 'visualizar produtos', 'visualizar', 1, '2025-03-07 00:06:37', '2025-03-07 00:06:37'),
(18, '152821d7-0f33-4b73-9516-487a3ece98dc', 'cadastrar produtos', 'cadastrar', 1, '2025-03-07 00:06:45', '2025-03-07 00:06:45'),
(19, '39ad145d-b017-4e87-b993-c53ca7165bd7', 'editar produtos', 'editar', 1, '2025-03-07 00:06:51', '2025-03-07 00:07:08'),
(20, '415b0e4f-ced7-4a9d-8127-83e42a3f9014', 'deletar produtos', 'deletar', 1, '2025-03-07 00:07:02', '2025-03-07 00:07:02'),
(21, 'aba9a48a-bbe8-4bb6-abe9-34a17154c665', 'visualizar vendas', 'visualizar', 1, '2025-03-07 22:45:57', '2025-03-07 22:45:57'),
(22, '7bdfb9ed-5550-4725-bb83-2f6f7ca5b588', 'cadastrar vendas', 'cadastrar', 1, '2025-03-07 22:46:03', '2025-03-07 22:46:03'),
(23, '43ea8dfb-8510-4b0b-833a-fec16705a4c1', 'editar vendas', 'editar', 1, '2025-03-07 22:46:09', '2025-03-07 22:46:09'),
(24, '88996482-da86-4d55-8879-d5f2387bc773', 'deletar vendas', 'deletar', 1, '2025-03-07 22:46:17', '2025-03-07 22:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `codigo` varchar(13) NOT NULL,
  `preco` float(7,2) NOT NULL,
  `estoque` int NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produto_servico`
--

CREATE TABLE `produto_servico` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `produtos_id` int NOT NULL,
  `servicos_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicos`
--

CREATE TABLE `servicos` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `preco` float(7,2) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `icone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'default.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `uuid`, `nome`, `email`, `cpf`, `telefone`, `senha`, `ativo`, `icone`, `created_at`, `updated_at`) VALUES
(1, '0661993e-7ae8-4146-8602-403f5edb92ea', 'Administrador ', 'admin@admin.com', '111.222.333-44', '(75) 9988-7766', '$2y$10$QNITTqPrt8aa0sICQsq2IuyiYzngUW4tFQKZq7wxwEqVnUOxvtUmy', 1, 'default.png', '2025-03-01 16:04:15', '2025-03-12 01:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `vendas`
--

CREATE TABLE `vendas` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `desconto` int DEFAULT '0',
  `total` float(7,2) NOT NULL DEFAULT '0.00',
  `situacao` enum('cancelada','em andamento','concluida') NOT NULL DEFAULT 'em andamento',
  `clientes_id` int NOT NULL,
  `usuarios_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venda_produto`
--

CREATE TABLE `venda_produto` (
  `id` int NOT NULL,
  `uuid` varchar(36) NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `produtos_id` int NOT NULL,
  `vendas_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`);

--
-- Indexes for table `os`
--
ALTER TABLE `os`
  ADD PRIMARY KEY (`id`,`clientes_id`,`usuarios_id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD UNIQUE KEY `fk_os_servico_os1` (`id`) USING BTREE,
  ADD KEY `fk_os_clientes_idx` (`clientes_id`),
  ADD KEY `fk_os_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `os_servico`
--
ALTER TABLE `os_servico`
  ADD PRIMARY KEY (`id`,`os_id`,`servicos_id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD KEY `fk_os_servico_os1_idx` (`os_id`),
  ADD KEY `fk_os_servico_servicos1_idx` (`servicos_id`);

--
-- Indexes for table `permissao_usuario`
--
ALTER TABLE `permissao_usuario`
  ADD PRIMARY KEY (`id`,`permissoes_id`,`usuarios_id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD KEY `fk_permissao_usuario_permissoes1_idx` (`permissoes_id`),
  ADD KEY `fk_permissao_usuario_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD UNIQUE KEY `fk_venda_produto_produtos1_idx` (`id`),
  ADD UNIQUE KEY `nome` (`nome`,`codigo`);

--
-- Indexes for table `produto_servico`
--
ALTER TABLE `produto_servico`
  ADD PRIMARY KEY (`id`,`produtos_id`,`servicos_id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD KEY `fk_produto_servico_produtos1_idx` (`produtos_id`),
  ADD KEY `fk_produto_servico_servicos1_idx` (`servicos_id`);

--
-- Indexes for table `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`);

--
-- Indexes for table `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id`,`clientes_id`,`usuarios_id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD UNIQUE KEY `fk_venda_produtos_vendas1` (`id`),
  ADD KEY `fk_vendas_clientes1_idx` (`clientes_id`),
  ADD KEY `fk_vendas_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD PRIMARY KEY (`id`,`produtos_id`,`vendas_id`),
  ADD UNIQUE KEY `uuid_UNIQUE` (`uuid`),
  ADD KEY `fk_venda_produto_produtos1_idx` (`produtos_id`),
  ADD KEY `fk_venda_produto_vendas1_idx` (`vendas_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `os`
--
ALTER TABLE `os`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `os_servico`
--
ALTER TABLE `os_servico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `permissao_usuario`
--
ALTER TABLE `permissao_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produto_servico`
--
ALTER TABLE `produto_servico`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `venda_produto`
--
ALTER TABLE `venda_produto`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `os`
--
ALTER TABLE `os`
  ADD CONSTRAINT `fk_os_clientes` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_os_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `os_servico`
--
ALTER TABLE `os_servico`
  ADD CONSTRAINT `fk_os_servico_os1` FOREIGN KEY (`os_id`) REFERENCES `os` (`id`),
  ADD CONSTRAINT `fk_os_servico_servicos1` FOREIGN KEY (`servicos_id`) REFERENCES `servicos` (`id`);

--
-- Constraints for table `permissao_usuario`
--
ALTER TABLE `permissao_usuario`
  ADD CONSTRAINT `fk_permissao_usuario_permissoes1` FOREIGN KEY (`permissoes_id`) REFERENCES `permissoes` (`id`),
  ADD CONSTRAINT `fk_permissao_usuario_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `produto_servico`
--
ALTER TABLE `produto_servico`
  ADD CONSTRAINT `fk_produto_servico_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_produto_servico_servicos1` FOREIGN KEY (`servicos_id`) REFERENCES `servicos` (`id`);

--
-- Constraints for table `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_vendas_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_vendas_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `venda_produto`
--
ALTER TABLE `venda_produto`
  ADD CONSTRAINT `fk_venda_produto_produtos1` FOREIGN KEY (`produtos_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `fk_venda_produto_vendas1` FOREIGN KEY (`vendas_id`) REFERENCES `vendas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
