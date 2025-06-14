<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<h2 class="perfil-title">Meus Tweets</h2>

<?php if (empty($meustweets)): ?>
    <p class="perfil-empty">Você ainda não postou nenhum tweet.</p>
<?php else: ?>
    <?php foreach ($meustweets as $t): ?>
        <div class="tweet-card">
            <p class="tweet-text"><?php echo nl2br(htmlspecialchars($t['texto'])); ?></p>
            <small class="tweet-date">
                <i class="bi bi-clock"></i>
                <?php echo date('d/m/Y H:i', strtotime($t['criado_em'])); ?>
            </small>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
