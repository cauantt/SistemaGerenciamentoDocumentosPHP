<?php
session_start();
include("conexao.php");

$nm_produto = $_POST['c_nome'];
$valor_produto = $_POST['c_valor'];
$ds_produto = $_POST['c_desc'];
$id_usuario = $_SESSION['id_usuario']; // Utilizar corretamente o id_usuario da sessão
$usuario = $_SESSION['usuario']; // Obter o nome do usuário da sessão

// Verifica se um arquivo PDF foi enviado
if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == UPLOAD_ERR_OK) {
    $pdf = $_FILES['pdf'];
    $tmp_pdf = $pdf['tmp_name'];
    $name_pdf = $pdf['name'];
    $type_pdf = $pdf['type'];

    // Diretório onde os arquivos serão salvos
    $upload_dir = '../uploads/';

    // Verifica se o arquivo enviado é PDF
    if ($type_pdf == 'application/pdf') {
        // Gerar um nome único para o arquivo PDF
        $nome_pdf = 'pdf-' . uniqid() . '.pdf';
        $caminho_pdf = $upload_dir . $nome_pdf;

        // Mover o arquivo PDF para a pasta de uploads
        if (move_uploaded_file($tmp_pdf, $caminho_pdf)) {
            // Preparar o nome do arquivo para salvar no banco de dados
            $nome_arquivo_bd = $nome_pdf;
        } else {
            // Mensagem de erro ao mover o arquivo
            echo "<script>alert('Erro ao mover o arquivo PDF para o diretório de uploads.'); window.location.href = 'cadastro_produto.php';</script>";
            exit();
        }
    } else {
        // Mensagem de erro de tipo de arquivo inválido
        echo "<script>alert('Apenas arquivos PDF são permitidos.'); window.location.href = 'cadastro_produto.php';</script>";
        exit();
    }
} else {
    // Se nenhum arquivo foi enviado, definir o nome do arquivo como vazio
    $nome_arquivo_bd = '';
}

// Prepared statement para inserção de produtos
$stmt = mysqli_prepare($conexao, "INSERT INTO tb_produto (nm_produto, ds_produto, nm_imagem_produto, pdf, vl_produto, id_usuario, usuario) 
                                 VALUES (?, ?, '', ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssis", $nm_produto, $ds_produto, $nome_arquivo_bd, $valor_produto, $id_usuario, $usuario);
$salvar = mysqli_stmt_execute($stmt);

if ($salvar) {
    // Mensagem de sucesso
    echo "<script>alert('Produto cadastrado com sucesso.'); window.location.href = 'listar_produto.php?id_usuario=" . $_SESSION['id_usuario'] . "';</script>";
} else {
    // Mensagem de erro ao salvar no banco de dados
    echo "<script>alert('Erro ao salvar produto no banco de dados.'); window.location.href = 'cadastro_produto.php';</script>";
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);
?>
