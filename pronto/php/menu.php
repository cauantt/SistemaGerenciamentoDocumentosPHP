<?php



// Verifica se 'id_usuario' está definido na sessão
if (isset($_SESSION['id_usuario'])) {
    // Se estiver definido, pode usar $_SESSION['id_usuario'] sem problemas
    $id_usuario = $_SESSION['id_usuario'];
} else {
    // Se não estiver definido, lida com o erro ou redireciona para página de login, por exemplo
    echo "Sessão não contém 'id_usuario'.";
    // Ou redireciona para página de login
    // header("Location: login.php");
    // exit();
}
?>


<div>
    <nav class="navbar navbar-light bg-light" style="min-height: 100px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
            <a class="nav-item nav-link active" href="http://localhost/pronto/php/listar_produto.php?id_usuario=<?php echo $_SESSION['id_usuario']; ?>">Resumo de Faturamento<span class="sr-only">(current)</span></a>

                <a class="nav-item nav-link" href="cadastro_produto.php">Cadastro</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <a class="nav-item nav-link" href="cadastro_usuario.php">Cadastro de Usuário</a>
                    <a class="nav-item nav-link" href="listar_usuarios.php">Listar Usuários</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') : ?>
                    <a class="nav-item nav-link" href="editar_conta.php">Editar Conta</a>
                    <a class="nav-item nav-link" href="https://wa.me/5534331633">Suporte</a>
                  

                <?php endif; ?>

                <a class="nav-item nav-link" href="index.html">Sair</a>
            </div>
        </div>

        
    </nav>
</div>
