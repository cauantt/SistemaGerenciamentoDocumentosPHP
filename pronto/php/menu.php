<div>
    <nav class="navbar navbar-light bg-light" style="min-height: 100px;">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="listar_produto.php">Resumo de Faturamento<span class="sr-only">(current)</span></a>
                <a class="nav-item nav-link" href="cadastro_produto.php">Cadastro</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <a class="nav-item nav-link" href="cadastro_usuario.php">Cadastro de Usuário</a>
                    <a class="nav-item nav-link" href="listar_usuarios.php">Listar Usuários</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') : ?>
                    <a class="nav-item nav-link" href="editar_conta.php">Editar Conta</a>
                <?php endif; ?>
                <a class="nav-item nav-link" href="index.html">Sair</a>
            </div>
        </div>
    </nav>
</div>
