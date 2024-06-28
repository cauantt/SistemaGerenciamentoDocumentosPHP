<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

$usuario = $_SESSION['usuario'];
$role = $_SESSION['role'];

mysqli_select_db($conexao, "bd_resolv");

if ($role == 'admin') {
    $sql = "SELECT * FROM tb_produto ORDER BY cd_produto DESC";
} else {
    $sql = "SELECT * FROM tb_produto WHERE usuario='$usuario' ORDER BY nm_produto DESC";
}

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro na consulta ao banco de dados: " . mysqli_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>PRODUCT BOX</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Resolv, Grupo Resolv, Team">
    <meta name="author" content="Rodrigo Topan, Igor Ponso, João Diwan">
    <meta name="description" content="Lista de produtos cadastrados">
    <link rel="stylesheet" type="text/css" href="../css/style-css.css">
        <!--LINK CDN BOOTSTRAP-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" 
        integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <!--LINK CDN BOOTSTRAP-->
    
    <script>
        function confirmarExclusao(produtoId) {
            if (confirm('Tem certeza que deseja excluir este produto?')) {
                window.location.href = 'excluir_produto.php?produto_id=' + produtoId;
            }
        }
    </script>
</head>
<body>
    <div class="container-fluid">
        <?php include("menu.php");?>
    </div>
    <div class="container">
        <div class="container-principal-produtos">
            <h4 class="page-header">Resumo de faturamento</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Usuario</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($linha = mysqli_fetch_array($resultado)) {
                                echo '<tr>';
                                echo '<td>'.$linha['cd_produto'].'</td>';
                                echo '<td>'.$linha['nm_produto'].'</td>';
                                echo '<td>'.$linha['usuario'] . '</td>';
                                echo '<td>'.$linha['vl_produto'].'</td>';
                                echo "<td>";
                                echo "<button type='button' class='btn btn-sm btn-info' data-toggle='modal' data-target='#myModal".$linha['cd_produto']."'>Mostrar</button>&nbsp;";
                                echo "<button type='button' class='btn btn-sm btn-danger' onclick='confirmarExclusao(" . $linha['cd_produto'] . ")'>Deletar</button>&nbsp;";
                                echo "</td>";
                                echo "</tr>";
                                ?>
                                <div class="modal fade" id="myModal<?php echo $linha['cd_produto'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <center><h3 class="modal-title" id="myModalLabel">Produto: <?php echo $linha['cd_produto'];?></h3></center>
                                            </div>
                                            <div class="modal-body">
                                                <h4><b>Nome:</b></h4>
                                                <p><?php echo $linha['nm_produto'];?></p>
                                                <?php
                                                if (!empty($linha['pdf'])) {
                                                    echo '<h4><b>PDF:</b></h4>';
                                                    echo '<p><a href="download_pdf.php?produto_id='.$linha['cd_produto'].'" target="_blank">Baixar PDF</a></p>';
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="4">Nenhum produto encontrado.</td></tr>';
                        }
                        mysqli_close($conexao);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include("dep_query.php");?>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmMqr7/8fzTNrGzKr7rRQeFzJJvT54R2IduwK9bvTPOK8b" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-LOXp0S5LUtV1X6JziFvP9wpvG6FD5EvXo1h7p3p3hS3+H24sD4Xk6pPzgfn8jKpi" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkdN7fM3k1y6U6sF6pD6w5Ohb5A5qjZQb7VqE5jnlWWS6G3e6o5e5LPu5v6c" crossorigin="anonymous"></script>

</body>
</html>
