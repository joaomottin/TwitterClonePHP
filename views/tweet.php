<a href="?url=home" class="btn btn-secondary btn-sm mb-3">Voltar</a>

<div class="card mb-4">
    <div class="card-body">
        <strong><?php echo htmlspecialchars($tweet['nome']); ?>:</strong>
        <p><?php echo htmlspecialchars($tweet['texto']); ?></p>
        <small class="text-muted"><?php echo $tweet['criado_em']; ?></small>
        
        <div class="mt-2">
            <form method="POST" action="?url=like/toggle/<?php echo $tweet['id']; ?>" style="display:inline;">
                <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>">
                <button type="submit" class="btn btn-<?php echo $userLiked ? 'primary' : 'outline-primary'; ?> btn-sm">
                    <?php echo $userLiked ? 'Descurtir' : 'Curtir'; ?>
                </button>
            </form>
            <span><?php echo $tweet['likes_count']; ?> likes</span>
        </div>
    </div>
</div>

<h5>Comentários</h5>

<?php foreach ($comentarios as $c): ?>
    <div class="card mb-2">
        <div class="card-body">
            <strong><?php echo htmlspecialchars($c['nome']); ?>:</strong>
            <p><?php echo htmlspecialchars($c['texto']); ?></p>
            <small class="text-muted"><?php echo $c['criado_em']; ?></small>

            <?php if ($c['user_id'] === $_SESSION['user_id']): ?>
                <a href="?url=comentario/editar/<?php echo $c['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                <form method="POST" action="?url=comentario/excluir/<?php echo $c['id']; ?>" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>">
                    <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<form method="POST" class="mt-4">
    <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>">
    <div class="mb-3">
        <textarea name="comentario" class="form-control" placeholder="Adicionar comentário..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Comentar</button>
</form>
