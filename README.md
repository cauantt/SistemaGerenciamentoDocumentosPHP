## Sistema de Gerenciamento de Documentos em PHP ##


 Um sistema desenvolvido em PHP que oferece autenticação de usuários com diferentes roles (admin e usuário). Os usuários podem realizar upload de arquivos PDF e informações para um banco de dados, listar seus documentos com datas de upload, baixar e deletar seus próprios arquivos, além de editar seus dados de login. Os administradores têm funcionalidades adicionais, como cadastrar novas contas, gerenciar todos os usuários e seus uploads, e realizar operações de exclusão de arquivos e usuários. Ideal para ambientes que requerem controle de acesso e gestão de documentos de forma eficiente. 

# Como Usar: #

1- Configuração do Banco de Dados:

 CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(50) NOT NULL,
  `nm_email` varchar(50) NOT NULL,
  `nm_senha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `uk_email` (`nm_email`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `tb_produto` (
  `cd_produto` int NOT NULL AUTO_INCREMENT,
  `nm_imagem_produto` varchar(140) NOT NULL,
  `nm_produto` date NOT NULL,
  `ds_produto` varchar(300) DEFAULT NULL,
  `pdf` blob NOT NULL,
  `vl_produto` decimal(10,2) NOT NULL,
  `nm_tipo_produto` varchar(50) NOT NULL,
  `id_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuario` varchar(100) NOT NULL,
  PRIMARY KEY (`cd_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

2 - Conexão com o banco de dados:

  Faça o ajuste e conexão ao banco de dados pelo arquivo: conexao.php


Uso:

Clone ou baixe o repositório.
Configure seu ambiente PHP para servir a aplicação.
Acesse a aplicação através de um navegador web.
Utilize a funcionalidade de login para autenticar como usuário ou administrador.
Faça upload, gerencie, baixe e delete arquivos conforme o papel do usuário.
Administradores podem gerenciar contas de usuários, visualizar todos os uploads e realizar ações administrativas.
Este sistema foi desenvolvido para fornecer capacidades eficientes de gerenciamento de documentos com controle de acesso baseado em roles utilizando PHP e MySQL. Ajuste configurações e funcionalidades conforme suas necessidades específicas.
