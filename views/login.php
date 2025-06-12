<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h2 class="text-center mb-4">Entrar</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>

                <div class="mt-3 text-center">
                    <a href="?url=register">Cadastrar-se</a> |
                    <a href="?url=recover">Esqueci a senha</a>
                </div>
            </form>
        </div>
    </div>
</div>
