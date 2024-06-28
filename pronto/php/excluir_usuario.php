<?php
session_start();

// Verifica se o usuário possui permissão de administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Verifica se o ID do usuário a ser excluído foi enviado via GET
if (!isset($_GET['usuario_id'])) {
    header("Location: listar_usuarios.php");
    exit();
}

// Incluir arquivo de conexão com o banco de dados
include("conexao.php");

// ID do usuário a ser excluído
$usuario_id = $_GET['usuario_id'];

// Query para excluir o usuário
$sql = "DELETE FROM tb_usuario WHERE cd_usuario = $usuario_id";

if (mysqli_query($conexao, $sql)) {
    echo "Usuário excluído com sucesso.";
} else {
    echo "Erro ao excluir usuário: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
