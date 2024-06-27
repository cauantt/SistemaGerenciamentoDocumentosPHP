<?php
if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];

    // Incluir arquivo de conexão
    include("conexao.php");
    mysqli_select_db($conexao, "bd_resolv");

    // Preparar e executar a query usando prepared statement para segurança
    $sql = "DELETE FROM tb_produto WHERE cd_produto = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $produto_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Redirecionar após a exclusão bem-sucedida
        header("Location: listar_produto.php");
        exit();
    } else {
        echo "Erro ao excluir o produto.";
    }

    // Fechar statement e conexão
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
} else {
    echo "ID do produto não especificado.";
}
?>
