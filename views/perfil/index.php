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
    
<h2 class="perfil-title">Dados do Usuário</h2>

<form action="?url=perfil/atualizar" method="post" class="perfil-form">
    <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>" />

    <label for="nome">Nome</label><br>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required><br><br>

    <label for="email">Email</label><br>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>

    <label for="senha">Nova senha (opcional)</label><br>
    <input type="password" id="senha" name="senha" placeholder="Deixe vazio para não alterar"><br><br>

    <button type="submit">Salvar</button>
</form>

<form action="?url=perfil/excluir" method="post" onsubmit="return confirm('Tem certeza que deseja excluir sua conta?');" style="margin-top: 20px;">
    <input type="hidden" name="csrf_token" value="<?php echo CsrfHelper::generateToken(); ?>" />
    <button type="submit" style="background-color: red; color: white; padding: 8px 12px; border: none; cursor: pointer;">
        Deletar conta
    </button>
</form>

<hr>


</body>
</html>
