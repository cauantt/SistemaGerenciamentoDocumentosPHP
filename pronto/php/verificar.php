<?php
include("conexao.php");

$email = "novo2@example.com"; // Altere para o email do usuário que deseja verificar
$senha = "senha_nova2"; // Altere para a senha que deseja verificar

mysqli_select_db($conexao, "bd_resolv");

// Buscar o usuário pelo email
$sql = mysqli_query($conexao, "SELECT * FROM tb_usuario WHERE nm_email='$email'") or die(mysqli_error($conexao));
$usuario = mysqli_fetch_assoc($sql);

if ($usuario) {
    $hash_banco = $usuario['nm_senha']; // O hash armazenado no banco de dados
    $senha_verificada = password_verify($senha, $hash_banco);

    if ($senha_verificada) {
        echo "Senha correta.";
    } else {
        echo "Senha incorreta.<br>";
        echo "Senha fornecida: " . htmlspecialchars($senha) . "<br>";
        echo "Hash do banco de dados: " . htmlspecialchars($hash_banco) . "<br>";
    }
} else {
    echo "Usuário não encontrado.";
}

mysqli_close($conexao);
?>