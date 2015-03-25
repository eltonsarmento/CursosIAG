-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Servidor: mysql116.prv.f1.k8.com.br.
-- Tempo de Geração: 25/03/2015 às 16:52
-- Versão do servidor: 5.5.41-MariaDB-0ubuntu0.14.04.2-log
-- Versão do PHP: 5.3.10-1ubuntu3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `cursosiag`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE IF NOT EXISTS `planos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `plano` varchar(255) NOT NULL,
  `meses` int(3) NOT NULL,
  `valor` decimal(6,2) NOT NULL,
  `descricao` text NOT NULL,
  `imagem_arquivo` varchar(255) NOT NULL,
  `codigoPlanoPagarme` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `excluido` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Fazendo dump de dados para tabela `planos`
--

INSERT INTO `planos` (`id`, `plano`, `meses`, `valor`, `descricao`, `imagem_arquivo`, `codigoPlanoPagarme`, `status`, `excluido`) VALUES
(1, 'TRIMESTRAL2', 4, 1499.00, '', '', '', 1, 1),
(2, 'Plano 1', 12, 100.00, 'plano 123', 'plano_imagem_2.jpg', '', 0, 1),
(3, 'Plano Bronze', 3, 209.70, 'Assinatura quem deseja estudar em ritmo acelerado. Você terá acesso a todos os cursos por três meses. Tempo suficiente para estudar diversos cursos.', 'plano_imagem_3.jpg', '', 1, 1),
(4, 'Plano Prata', 6, 419.40, 'Assinatura ideal para quem deseja estudar com tranquilidade. São 6 meses para estudar o curso que desejar, a hora que desejar. Você ainda poderá renovar antes que seu acesso expire.', 'plano_imagem_4.jpg', '', 1, 1),
(5, 'Plano Ouro', 12, 778.80, 'Assinatura ideal para quem deseja se especializar em uma área. Plano perfeito para estudar todos os cursos de uma área e se tornar um profissional diferenciado.', 'plano_imagem_5.jpg', '', 1, 1),
(6, 'Plano Platinum', 24, 1197.60, 'Assinatura ideal para quem deseja ter acesso a todos os cursos, inclusive lançamentos, por um longo tempo. Plano perfeito para estudar diversas áreas e se tornar um profissional ainda mais completo.', 'plano_imagem_6.jpg', '', 1, 1),
(7, 'Plano Teste 01', 10, 100.00, 'teste', 'plano_imagem_7.jpg', '', 0, 1),
(8, 'Plano Bronze', 3, 209.70, 'Assinatura para quem deseja estudar em ritmo acelerado. Você terá acesso a todos os cursos por três meses. Tempo suficiente para estudar diversos cursos.', 'plano_imagem_8.jpg', '', 1, 1),
(9, 'Plano Prata', 6, 419.40, 'Assinatura ideal para quem deseja estudar com tranquilidade. São 6 meses para estudar o curso que desejar, a hora que desejar. Você ainda poderá renovar antes que seu acesso expire.', 'plano_imagem_9.jpg', '', 1, 1),
(10, 'Plano Ouro', 12, 778.80, 'Assinatura ideal para quem deseja se especializar em uma área. Plano perfeito para estudar todos os cursos de uma área e se tornar um profissional diferenciado.', 'plano_imagem_10.jpg', '', 1, 1),
(11, 'Plano Platinum', 24, 1197.60, 'Assinatura ideal para quem deseja ter acesso a todos os cursos, inclusive lançamentos, por um longo tempo. Plano perfeito para estudar diversas áreas e se tornar um profissional ainda mais completo.', 'plano_imagem_11.jpg', '', 1, 1),
(12, 'Plano Starter', 1, 89.90, 'O plano Starter é ideal para quem deseja garantir acesso a todos os cursos, o tempo inteiro, e ainda pagar um valor super baixo todos os meses.', 'plano_imagem_12.jpg', '', 0, 1),
(13, 'Plano Plus', 3, 239.70, 'O plano Plus é ideal para quem deseja garantir acesso a todos os cursos por um tempo maior, não se preocupar com renovações mensais e ainda economizar.', 'plano_imagem_13.jpg', '', 0, 1),
(14, 'Plano Pro', 6, 419.40, 'O plano Pro é ideal para quem sabe que carreira quer seguir e não quer perder tempo. Além de acesso a todos os cursos você economiza 120 reais em assinaturas.', 'plano_imagem_14.jpg', '', 0, 1),
(15, 'Plano Premium', 12, 718.80, 'O plano Premium é perfeito para quem não quer ficar sem acesso e ainda aproveitar cada lançamento por um ano. Além de acessar todos os cursos você economiza 240 reais em assinaturas.', 'plano_imagem_15.jpg', '', 0, 1),
(16, 'Plano Super', 24, 1197.60, 'O plano Super é perfeito para quem deseja ser um profissional diferente. O aluno pode estudar com calma, passo a passo, área por área sem se preocupar com acesso. Além disso economiza 480 reais em assinaturas.', 'plano_imagem_16.jpg', '', 0, 1),
(17, 'teste deslogar', 10, 100.00, '00', 'plano_imagem_17.jpg', '', 0, 1),
(18, 'Plano Teste', 1, 1.00, 'Plano para teste', 'plano_imagem_18.jpg', '', 0, 1),
(19, 'Plano Plus', 3, 239.70, 'O plano Plus é ideal para quem deseja garantir acesso a todos os cursos* por um tempo maior, sem se preocupar com renovações mensais e ainda economizar.\n\n*Não permite acesso as Carreiras, apenas no plano Premium&#33;\n\n', '', '150', 1, 0),
(20, 'Plano Premium', 12, 718.80, 'O plano Premium é perfeito para quem não quer ficar sem acesso e ainda aproveitar cada lançamento por um ano. Além de acessar todos os cursos  você economiza 240 reais em assinaturas.\n\nPermite acesso a todas as Carreiras do IAG&#33;', '', '151', 1, 0),
(21, 'Plano Pro', 6, 419.40, 'O plano Pro é ideal para quem sabe que carreira quer seguir e não quer perder tempo. Além de acesso a todos os cursos* você economiza 120 reais em assinaturas.\n\n*Não permite acesso as Carreiras, apenas no plano Premium&#33;', '', '152', 1, 0),
(22, 'Plano Starter', 1, 89.90, 'O plano Starter é ideal para quem deseja garantir acesso a todos os cursos*, o tempo inteiro, e ainda pagar um valor super baixo todos os meses.\n\n*Não permite acesso as Carreiras, apenas no plano Premium&#33;', '', '153', 0, 0),
(23, 'Plano Super', 24, 1197.60, 'O plano Super é perfeito para quem deseja ser um profissional diferente. O aluno pode estudar com calma, passo a passo, área por área sem se preocupar com acesso. Além disso economiza 480 reais em assinaturas.', 'plano_imagem_23.jpg', '', 1, 1),
(24, 'Plano Teste', 1, 1.00, 'Plano para teste', 'plano_imagem_24.jpg', '', 1, 1),
(25, 'Plano teste 02', 1, 1.00, 'teste', 'plano_imagem_25.jpg', '', 0, 1),
(26, 'Plano Teste 03', 10, 1.00, 'Descrição', 'plano_imagem_26.jpg', '', 0, 1),
(27, 'Plano teste conexao', 1, 1000.00, 'teste', 'plano_imagem_27.jpg', '', 0, 1),
(28, 'Plano teste MoIP', 1, 1000.00, 'teste', 'plano_imagem_28.jpg', '', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
