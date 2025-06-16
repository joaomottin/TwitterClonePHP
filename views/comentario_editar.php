<a href="?url=home" class="btn btn-secondary btn-sm mb-3">Voltar</a>

<form method="POST" action="?url=comentario/atualizar/<?php echo $comentario['id']; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>">
    <div class="mb-3">
        <textarea name="texto" class="form-control" required><?php echo htmlspecialchars($comentario['texto']); ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Atualizar Comentário</button>
</form>
