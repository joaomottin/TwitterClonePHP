<link rel="stylesheet" href="css/login.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="login-card">

                <h2 class="text-center mb-4 login-title">Entrar</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="demo-credentials">
                    <strong>Usuários de teste:</strong><br>
                    Email: joao@gmail.com<br>
                    Senha: 123456
                    <hr>
                    Email: kauanlima@gmail.com<br>
                    Senha: senha123
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </div>

                    <div class="text-center auth-links">
                        <a href="?url=register">Cadastrar-se</a> |
                        <a href="?url=recover">Esqueci a senha</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
