<h2>Contato</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-success">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label" for="nome">Nome</label>
        <input
            type="text"
            id="nome"
            name="nome"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label" for="email">E-mail</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label" for="assunto">Assunto</label>
        <input
            type="text"
            id="assunto"
            name="assunto"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label" for="mensagem">Mensagem</label>
        <textarea
            id="mensagem"
            name="mensagem"
            class="form-control"
            rows="4"
            required
        ></textarea>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">
            Enviar
        </button>
    </div>
</form>
