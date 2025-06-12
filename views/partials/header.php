<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>TwitterClone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="?url=home">TwitterClone</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="?url=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?url=perfil">Meu Perfil</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="?url=contato">Contato</a>
                </li>
            </ul>

            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="navbar-text me-3">
                    Olá, <?php echo htmlspecialchars($_SESSION['user_nome']); ?>
                </span>
                <a class="btn btn-outline-danger" href="?url=logout">Sair</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container">
