<a href="?url=home" class="btn btn-secondary btn-sm mb-3">Voltar</a>

<div class="card mb-4">
    <div class="card-body">
        <strong><?php echo htmlspecialchars($tweet['nome']); ?>:</strong>
        <p><?php echo htmlspecialchars($tweet['texto']); ?></p>
        <small class="text-muted"><?php echo $tweet['criado_em']; ?></small>
    </div>
</div>

<h5>Comentários</h5>

<?php foreach ($comentarios as $c): ?>
    <div class="card mb-2">
        <div class="card-body">
            <strong><?php echo htmlspecialchars($c['nome']); ?>:</strong>
            <p><?php echo htmlspecialchars($c['texto']); ?></p>
            <small class="text-muted"><?php echo $c['criado_em']; ?></small>
        </div>
    </div>
<?php endforeach; ?>

<form method="POST" class="mt-4">
    <div class="mb-3">
        <textarea name="comentario" class="form-control" placeholder="Adicionar comentário..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Comentar</button>
</form>
