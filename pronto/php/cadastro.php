<?php
session_start();
include("conexao.php");

$nm_produto = $_POST['c_nome'];
$valor_produto = $_POST['c_valor'];
$tipo_produto = $_POST['c_tipo']; 
$ds_produto = $_POST['c_desc'];
$usuario = $_SESSION['usuario']; // Obtém o usuário da sessão

$pdf = $_FILES['pdf'];
$tmp_pdf = $pdf['tmp_name'];
$name_pdf = $pdf['name'];
$type_pdf = $pdf['type'];

mysqli_select_db($conexao, "bd_resolv");

if (!empty($name_pdf) && $type_pdf == 'application/pdf') {
    $conteudo_pdf = addslashes(file_get_contents($tmp_pdf));
    $nome_pdf = 'pdf-' . uniqid() . '.pdf';

    $sql = "INSERT INTO tb_produto (nm_produto, ds_produto, nm_imagem_produto, pdf, vl_produto, nm_tipo_produto, usuario) 
            VALUES ('$nm_produto', '$ds_produto', '', '$conteudo_pdf', '$valor_produto', '$tipo_produto', '$usuario')";
    $salvar = mysqli_query($conexao, $sql);

    if ($salvar) {
        header("Location: listar_produto.php");
        exit();
    } else {
        echo "Erro ao salvar produto no banco de dados.";
    }
} else {
    echo "Apenas arquivos PDF são permitidos.";
}

mysqli_close($conexao);
?>
