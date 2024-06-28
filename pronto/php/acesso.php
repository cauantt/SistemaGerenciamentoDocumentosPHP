<?php
session_start();
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['c_email'];
    $senha = $_POST['c_senha'];

    // Preparar a consulta usando prepared statement
    $sql = "SELECT * FROM tb_usuario WHERE nm_email=? LIMIT 1";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    // Obter resultados
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        $hash_banco = $usuario['nm_senha'];

        // Verificar a senha usando password_verify
        if (password_verify($senha, $hash_banco)) {
            // Iniciar a sessão
            $_SESSION['usuario'] = $usuario['nm_usuario'];
            $_SESSION['role'] = $usuario['role']; // Adicionar o papel do usuário na sessão
            header("Location: listar_produto.php");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}
?>
