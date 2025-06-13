<div class="container mt-3">
    <h3>Editar Tweet</h3>
    <form method="post" action="?url=tweet/atualizar/<?php echo $tweet['id']; ?>">
        <div class="form-group">
            <textarea name="texto" class="form-control" rows="3"><?php echo htmlspecialchars($tweet['texto']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Atualizar</button>
        <a href="?url=home" class="btn btn-secondary mt-2">Cancelar</a>
    </form>
</div>
