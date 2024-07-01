<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

$usuario = $_SESSION['usuario'];

// Buscar dados do usuário atual
$sql = "SELECT * FROM tb_usuario WHERE nm_usuario = '$usuario'";
$resultado = mysqli_query($conexao, $sql);
$dados_usuario = mysqli_fetch_assoc($resultado);

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Conta</title>
    <!-- Links para CSS e Bootstrap omitidos por brevidade -->
    <link rel="stylesheet" type="text/css" href="../css/style-css.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <?php include("menu.php"); ?>
    </div>
    <div class="container">
        <h2>Editar Conta</h2>
        <form method="post" action="atualizar_conta.php">
            <div class="form-group">
                <label for="c_nome">Nome:</label>
                <input type="text" class="form-control" id="c_nome" name="c_nome" value="<?php echo $dados_usuario['nm_usuario']; ?>" required>
            </div>
            <div class="form-group">
                <label for="c_email">Email:</label>
                <input type="email" class="form-control" id="c_email" name="c_email" value="<?php echo $dados_usuario['nm_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="c_senha">Nova Senha:</label>
                <input type="password" class="form-control" id="c_senha" name="c_senha">
                <small class="form-text text-muted">Deixe em branco para manter a senha atual.</small>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
    <?php include("dep_query.php");?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmMqr7/8fzTNrGzKr7rRQeFzJJvT54R2IduwK9bvTPOK8b" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-LOXp0S5LUtV1X6JziFvP9wpvG6FD5EvXo1h7p3p3hS3+H24sD4Xk6pPzgfn8jKpi" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkdN7fM3k1y6U6sF6pD6w5Ohb5A5qjZQb7VqE5jnlWWS6G3e6o5e5LPu5v6c" crossorigin="anonymous"></script>
</body>
</html>
