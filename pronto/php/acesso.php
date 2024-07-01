<?php
session_start();
include("conexao.php");

$id_usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : null;
$mensagem = '';

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
            $_SESSION['id_usuario'] = $usuario['id_usuario']; // Adicionar o id_usuario na sessão
            $_SESSION['role'] = $usuario['role']; // Adicionar o papel do usuário na sessão

            // Debug para verificar se os valores estão sendo armazenados corretamente na sessão
            var_dump($_SESSION);

            header("Location: listar_produto.php?id_usuario=".$_SESSION['id_usuario']);
            exit();
        } else {
            // Definir a mensagem de erro
            $mensagem = "Senha incorreta.";
        }
    } else {
        // Definir a mensagem de erro
        $mensagem = "Usuário não encontrado.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login</title>
  

    <script>
    // JavaScript para exibir alerta e redirecionar
    window.onload = function() {
        <?php
        // Exibir a mensagem de erro e redirecionar, se houver
        if (!empty($mensagem)) {
            // Escapar a mensagem para evitar problemas com aspas
            $mensagem_js = addslashes($mensagem);
            echo "alert('$mensagem_js');";
            echo "window.location.href = 'index.html';";
        }
        ?>
    };
    </script>
</head>



</html>
