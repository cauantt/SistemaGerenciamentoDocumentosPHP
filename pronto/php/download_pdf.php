<?php
include("conexao.php");

if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];

    // Consulta para obter o nome do arquivo PDF
    $sql = "SELECT pdf FROM tb_produto WHERE cd_produto=?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $produto_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome_pdf);
    mysqli_stmt_fetch($stmt);

    // Caminho completo do arquivo PDF na pasta uploads
    $pdf_path = '../uploads/' . $nome_pdf;

    // Verificar se o arquivo existe
    if (file_exists($pdf_path)) {
        // Configurações para forçar o download do arquivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($pdf_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pdf_path));
        readfile($pdf_path);
        exit;
    } else {
        die('Arquivo PDF não encontrado.');
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
} else {
    die('ID do produto não especificado.');
}
?>
