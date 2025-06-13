<form method="POST" class="mb-4">
    <div class="mb-3">
        <textarea name="texto" rows="2" class="form-control" placeholder="O que está acontecendo?" required></textarea>
    </div>
    <button class="btn btn-primary">Tweetar</button>
</form>

<?php foreach ($tweets as $t): ?>
    <div class="card mb-3">
        <div class="card-body">
            <strong><?php echo htmlspecialchars($t['nome']); ?>:</strong>
            <p><?php echo htmlspecialchars($t['texto']); ?></p>
            <small class="text-muted"><?php echo $t['criado_em']; ?></small>
            <br>
            <a href="?url=tweet/<?php echo $t['id']; ?>">Ver comentários</a>
        </div>
    </div>

    <div class="mt-1">
        <a href="?url=tweet/editar/<?php echo $t['id']; ?>">Editar</a> |
        <a href="?url=tweet/excluir/<?php echo $t['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
    </div>

<?php endforeach; ?>
