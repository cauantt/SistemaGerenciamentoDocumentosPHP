<?php
session_start();
include("conexao.php");

$nm_produto = $_POST['c_nome'];
$valor_produto = $_POST['c_valor'];
$ds_produto = $_POST['c_desc'];
$id_usuario = $_SESSION['id_usuario']; // Utilizar corretamente o id_usuario da sessão
$usuario = $_SESSION['usuario']; // Obter o nome do usuário da sessão

$pdf = $_FILES['pdf'];
$tmp_pdf = $pdf['tmp_name'];
$name_pdf = $pdf['name'];
$type_pdf = $pdf['type'];

mysqli_select_db($conexao, "bd_resolv");

if (!empty($name_pdf) && $type_pdf == 'application/pdf') {
    $conteudo_pdf = addslashes(file_get_contents($tmp_pdf));
    $nome_pdf = 'pdf-' . uniqid() . '.pdf';

    // Prepared statement para inserção de produtos
    $stmt = mysqli_prepare($conexao, "INSERT INTO tb_produto (nm_produto, ds_produto, nm_imagem_produto, pdf, vl_produto, id_usuario, usuario) 
                                     VALUES (?, ?, '', ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssis", $nm_produto, $ds_produto, $conteudo_pdf, $valor_produto, $id_usuario, $usuario);
    $salvar = mysqli_stmt_execute($stmt);

    if ($salvar) {
        header("Location: listar_produto.php?id_usuario=".$_SESSION['id_usuario']);
        exit();
    } else {
        echo "Erro ao salvar produto no banco de dados.";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Apenas arquivos PDF são permitidos.";
}

mysqli_close($conexao);
?>
