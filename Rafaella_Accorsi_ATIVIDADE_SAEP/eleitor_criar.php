<?php
require 'db.php';
require 'functions.php';

$erro = '';
$nome = $numero_titulo = $cidade = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $numero_titulo = trim($_POST['numero_titulo'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');

    if ($nome === '' || $numero_titulo === '') {
        $erro = 'Nome e número do título são obrigatórios.';
    } else {
        // Verifica se já existe um eleitor com o mesmo número de título
        $check = $pdo->prepare("SELECT COUNT(*) FROM eleitor WHERE numero_titulo = :numero_titulo");
        $check->execute(['numero_titulo' => $numero_titulo]);
        if ($check->fetchColumn() > 0) {
            $erro = 'Já existe um eleitor com esse número de título.';
        } else {
            $stmt = $pdo->prepare("INSERT INTO eleitor (nome, numero_titulo, cidade) VALUES (:nome, :numero_titulo, :cidade)");
            $stmt->execute([
                'nome' => $nome,
                'numero_titulo' => $numero_titulo,
                'cidade' => $cidade,
            ]);
            redirecionar('index.php?msg=' . urlencode('Eleitor criado com sucesso!'));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo eleitor - Sistema de Eleição</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Novo eleitor</h1>
    <p class="subtitulo">Preencha os dados para cadastrar um novo eleitor</p>

    <div class="card">
        <?php if ($erro): ?>
            <div class="alert alert-erro"><?= limpar($erro) ?></div>
        <?php endif; ?>

        <form method="post" action="eleitor_criar.php">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= limpar($nome) ?>" required>

            <label for="numero_titulo">Número do Título</label>
            <input type="text" id="numero_titulo" name="numero_titulo" value="<?= limpar($numero_titulo) ?>" required>

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?= limpar($cidade) ?>">

            <button class="btn btn-primario" type="submit">Salvar</button>
            <a class="btn btn-secundario" href="index.php">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>
