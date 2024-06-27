<?php
function upload($tmp, $nome, $pasta) {
    // Verifica se o arquivo temporário existe
    if (!file_exists($tmp)) {
        return false;
    }

    // Move o arquivo temporário para o diretório especificado
    if (!move_uploaded_file($tmp, "$pasta/$nome")) {
        return false;
    }

    // Retorna o nome do arquivo salvo
    return $nome;
}
?>
