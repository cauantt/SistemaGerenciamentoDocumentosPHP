<?php
include("conexao.php");

$nome = "caua";
$email = "caua@gmail.com";
$senha = "caua";
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "INSERT INTO tb_usuario (nm_usuario, nm_email, nm_senha, role) VALUES (?, ?, ?, ?)";
$role = 'admin'; // Defina o papel do usuário
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $senhaHash, $role);

if ($stmt->execute()) {
    echo "Usuário criado com sucesso.";
} else {
    echo "Erro ao criar usuário: " . $conexao->error;
}

$stmt->close();
$conexao->close();
?>