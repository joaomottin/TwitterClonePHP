<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h2 class="text-center mb-4">Recuperar Senha</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>" />

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">CPF</label>
                    <input type="text" name="cpf" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Data de nascimento</label>
                    <input type="date" name="data_nascimento" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-warning">Redefinir</button>
                </div>
            </form>
        </div>
    </div>
</div>
