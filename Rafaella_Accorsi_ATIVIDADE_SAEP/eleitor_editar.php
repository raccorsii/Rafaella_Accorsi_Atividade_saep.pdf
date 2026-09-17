<?php
require 'db.php';
require 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    redirecionar('index.php');
}

$stmt = $pdo->prepare("SELECT * FROM eleitor WHERE id_eleitor = :id");
$stmt->execute(['id' => $id]);
$eleitor = $stmt->fetch();

if (!$eleitor) {
    redirecionar('index.php?msg=' . urlencode('Eleitor não encontrado.'));
}

$erro = '';
$nome = $eleitor['nome'];
$numero_titulo = $eleitor['numero_titulo'];
$cidade = $eleitor['cidade'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $numero_titulo = trim($_POST['numero_titulo'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');

    if ($nome === '' || $numero_titulo === '') {
        $erro = 'Nome e número do título são obrigatórios.';
    } else {
        $check = $pdo->prepare("SELECT COUNT(*) FROM eleitor WHERE numero_titulo = :numero_titulo AND id_eleitor != :id");
        $check->execute(['numero_titulo' => $numero_titulo, 'id' => $id]);
        if ($check->fetchColumn() > 0) {
            $erro = 'Já existe outro eleitor com esse número de título.';
        } else {
            $stmt = $pdo->prepare("UPDATE eleitor SET nome = :nome, numero_titulo = :numero_titulo, cidade = :cidade WHERE id_eleitor = :id");
            $stmt->execute([
                'nome' => $nome,
                'numero_titulo' => $numero_titulo,
                'cidade' => $cidade,
                'id' => $id,
            ]);
            redirecionar('index.php?msg=' . urlencode('Eleitor atualizado com sucesso!'));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar eleitor - Sistema de Eleição</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Editar eleitor #<?= (int)$id ?></h1>
    <p class="subtitulo">Atualize os dados do eleitor</p>

    <div class="card">
        <?php if ($erro): ?>
            <div class="alert alert-erro"><?= limpar($erro) ?></div>
        <?php endif; ?>

        <form method="post" action="eleitor_editar.php?id=<?= (int)$id ?>">
            <input type="hidden" name="id" value="<?= (int)$id ?>">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= limpar($nome) ?>" required>

            <label for="numero_titulo">Número do Título</label>
            <input type="text" id="numero_titulo" name="numero_titulo" value="<?= limpar($numero_titulo) ?>" required>

            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" value="<?= limpar($cidade) ?>">

            <button class="btn btn-primario" type="submit">Atualizar</button>
            <a class="btn btn-secundario" href="index.php">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>
