<?php
// Verifica se foi passado o ID do produto via GET
if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];

    include("conexao.php");
    mysqli_select_db($conexao, "bd_resolv");

    // Query para obter o PDF do banco de dados
    $sql = "SELECT pdf FROM tb_produto WHERE cd_produto = $produto_id";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $linha = mysqli_fetch_array($resultado);

        // Define o nome do arquivo para download (pode ser ajustado conforme necessário)
        $nome_arquivo = 'produto_' . $produto_id . '.pdf';

        // Configurações do cabeçalho para forçar o download do PDF
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($linha['pdf']));
        
        // Saída do conteúdo do PDF armazenado no banco de dados
        echo $linha['pdf'];
        exit();
    } else {
        echo "Produto não encontrado ou PDF não disponível.";
    }

    mysqli_close($conexao);
} else {
    echo "ID do produto não especificado.";
}
?>
