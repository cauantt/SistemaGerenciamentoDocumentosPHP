<?php
session_start();

// Verifica se o usuário possui permissão de administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Incluir arquivo de conexão com o banco de dados
include("conexao.php");

// Consulta para selecionar todos os usuários
$sql = "SELECT * FROM tb_usuario";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro na consulta ao banco de dados: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Usuários</title>
    <!-- Links para CSS e Bootstrap omitidos por brevidade -->
    <link rel="stylesheet" type="text/css" href="../css/style-css.css">
        <!--LINK CDN BOOTSTRAP-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
        integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <?php include("menu.php");?>
    </div>
    <div class="container">
        <h2>Listar Usuários</h2>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($linha = mysqli_fetch_array($resultado)) {
                            echo '<tr>';
                            echo '<td>'.$linha['cd_usuario'].'</td>';
                            echo '<td>'.$linha['nm_usuario'].'</td>';
                            echo '<td>'.$linha['nm_email'].'</td>';
                            echo '<td>';
                            // Botão para excluir usuário com confirmação
                            echo "<button type='button' class='btn btn-sm btn-danger' onclick='confirmarExclusao(" . $linha['cd_usuario'] . ")'>Excluir</button>&nbsp;";
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">Nenhum usuário encontrado.</td></tr>';
                    }
                    mysqli_close($conexao);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Função para confirmar exclusão do usuário
        function confirmarExclusao(usuarioId) {
            if (confirm('Tem certeza que deseja excluir este usuário?')) {
                window.location.href = 'excluir_usuario.php?usuario_id=' + usuarioId;
            }
        }
    </script>
    <?php include("dep_query.php");?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmMqr7/8fzTNrGzKr7rRQeFzJJvT54R2IduwK9bvTPOK8b" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-LOXp0S5LUtV1X6JziFvP9wpvG6FD5EvXo1h7p3p3hS3+H24sD4Xk6pPzgfn8jKpi" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkdN7fM3k1y6U6sF6pD6w5Ohb5A5qjZQb7VqE5jnlWWS6G3e6o5e5LPu5v6c" crossorigin="anonymous"></script>
</body>
</html>
