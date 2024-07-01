<?php
session_start();

// Verifica se o usuário possui permissão de administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html"); // Redireciona para a página inicial se não for administrador
    exit();
}

include("conexao.php");

$mensagem = ''; // Inicializa a variável de mensagem vazia

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nm_usuario = $_POST['c_nome'];
    $nm_email = $_POST['c_email'];
    $nm_senha = $_POST['c_senha'];
    $role = $_POST['c_role']; // Papel do usuário

    // Verificar se já existe um usuário com o mesmo email
    $sql_verifica = "SELECT * FROM tb_usuario WHERE nm_email = '$nm_email'";
    $resultado_verifica = mysqli_query($conexao, $sql_verifica);
    if (mysqli_num_rows($resultado_verifica) > 0) {
        $mensagem = "Já existe um usuário cadastrado com este email.";
    } else {
        // Hash da senha usando password_hash
        $senhaHash = password_hash($nm_senha, PASSWORD_DEFAULT);

        // Inserir novo usuário no banco de dados
        $sql = "INSERT INTO tb_usuario (nm_usuario, nm_email, nm_senha, role) VALUES ('$nm_usuario', '$nm_email', '$senhaHash', '$role')";
        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            $mensagem = "Usuário cadastrado com sucesso.";
        } else {
            $mensagem = "Erro ao cadastrar usuário: " . mysqli_error($conexao);
        }
    }

    mysqli_close($conexao);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <!-- Links para CSS e Bootstrap omitidos por brevidade -->
    <link rel="stylesheet" type="text/css" href="../css/style-css.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <?php include("menu.php"); ?>
    </div>
    <div class="container">
        <h2>Cadastro de Novo Usuário</h2>
        <!-- Exibir mensagem de sucesso ou erro -->
        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo strpos($mensagem, 'sucesso') !== false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="c_nome">Nome:</label>
                <input type="text" class="form-control" id="c_nome" name="c_nome" required>
            </div>
            <div class="form-group">
                <label for="c_email">Email:</label>
                <input type="email" class="form-control" id="c_email" name="c_email" required>
            </div>
            <div class="form-group">
                <label for="c_senha">Senha:</label>
                <input type="password" class="form-control" id="c_senha" name="c_senha" required>
            </div>
            <div class="form-group">
                <label for="c_role">Papel:</label>
                <select class="form-control" id="c_role" name="c_role">
                    <option value="admin">Admin</option>
                    <option value="user">Usuário</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <?php include("dep_query.php"); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmMqr7/8fzTNrGzKr7rRQeFzJJvT54R2IduwK9bvTPOK8b" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-LOXp0S5LUtV1X6JziFvP9wpvG6FD5EvXo1h7p3p3hS3+H24sD4Xk6pPzgfn8jKpi" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkdN7fM3k1y6U6sF6pD6w5Ohb5A5qjZQb7VqE5jnlWWS6G3e6o5e5LPu5v6c" crossorigin="anonymous"></script>
</body>
</html>
