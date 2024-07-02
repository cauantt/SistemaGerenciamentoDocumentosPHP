<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

$role = $_SESSION['role'];
$id_usuario_sessao = $_SESSION['id_usuario']; // Supondo que você armazene o ID do usuário na sessão

// Se o usuário não for administrador, usa o próprio id_usuario da sessão
if ($role != 'admin') {
    $id_usuario = $id_usuario_sessao;
} else {
    // Se for administrador, permite o uso do id_usuario da URL se estiver definido
    $id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : null;
}

mysqli_select_db($conexao, "bd_resolv");

if ($id_usuario === null) {
    $sql = "SELECT * FROM tb_produto ORDER BY cd_produto DESC";
} else {
    $sql = "SELECT * FROM tb_produto WHERE id_usuario='$id_usuario' ORDER BY cd_produto DESC";
}

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro na consulta ao banco de dados: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Seu código HTML continua aqui -->
</head>
<body>
    <!-- Seu corpo HTML continua aqui -->
</body>
</html>

