<link rel="stylesheet" href="css/timeline.css">

<form method="POST" class="mb-4">
    <textarea name="texto" rows="2" class="form-control" placeholder="O que está acontecendo?" required></textarea>
    <button class="btn btn-primary mt-2">Tweetar</button>
</form>

<?php foreach ($tweets as $t): ?>
    <div class="tweet">
        <div class="tweet-header">
            <strong><?php echo htmlspecialchars($t['nome']); ?></strong>
            <small><?php echo date('d/m/Y H:i', strtotime($t['criado_em'])); ?></small>
        </div>
        <p class="tweet-text"><?php echo nl2br(htmlspecialchars($t['texto'])); ?></p>
        <div class="tweet-actions">
            <a href="?url=tweet/<?php echo $t['id']; ?>">Comentários</a> |
            <a href="?url=tweet/editar/<?php echo $t['id']; ?>">Editar</a> |
            <a href="?url=tweet/excluir/<?php echo $t['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
        </div>
    </div>
<?php endforeach; ?>
