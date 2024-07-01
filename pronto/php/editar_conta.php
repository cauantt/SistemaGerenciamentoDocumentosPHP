<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Você não está logado. Redirecionando para página de login...'); window.location.href = 'index.html';</script>";
    exit();
}

$usuario = $_SESSION['usuario'];
$nome = $_POST['c_nome'];
$email = $_POST['c_email'];
$novaSenha = $_POST['c_senha'];

// Preparar a consulta para atualizar os dados do usuário no banco de dados
$sql = "UPDATE tb_usuario SET nm_usuario = ?, nm_email = ?";

// Array para armazenar os tipos de dados para o bind_param
$tipos = "ss";
$valores = [$nome, $email];

// Verificar se foi fornecida uma nova senha
if (!empty($novaSenha)) {
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $sql .= ", nm_senha = ?";
    $tipos .= "s";
    $valores[] = $senhaHash;
}

$sql .= " WHERE nm_usuario = ?";
$tipos .= "s";
$valores[] = $usuario;

// Preparar a declaração SQL com prepared statement
$stmt = $conexao->prepare($sql);

// Verificar se a preparação da declaração foi bem-sucedida
if ($stmt === false) {
    echo "<script>alert('Erro na preparação da consulta. Redirecionando para página de edição de conta...'); window.location.href = 'editar_conta.php';</script>";
    exit();
} else {
    // Fazer bind dos parâmetros
    $bind_params = array_merge([$tipos], $valores);
    $bind_params_ref = [];
    foreach ($bind_params as $key => $value) {
        $bind_params_ref[$key] = &$bind_params[$key];
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_params_ref);

    // Executar a consulta preparada
    if ($stmt->execute()) {
        echo "<script>alert('Dados atualizados com sucesso.'); window.location.href = 'editar_conta.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar dados: " . $stmt->error . "'); window.location.href = 'editar_conta.php';</script>";
    }

    // Fechar a declaração
    $stmt->close();
}

// Fechar a conexão
$conexao->close();
?>
