<?php
require 'db.php';
require 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    redirecionar('candidatos.php');
}

$stmt = $pdo->prepare("SELECT * FROM candidatos WHERE id_candidato = :id");
$stmt->execute(['id' => $id]);
$candidato = $stmt->fetch();

if (!$candidato) {
    redirecionar('candidatos.php?msg=' . urlencode('Candidato não encontrado.'));
}

$erro = '';
$nome = $candidato['nome'];
$numero_candidato = $candidato['numero_candidato'];
$cargo = $candidato['cargo'];
$partido_ficticio = $candidato['partido_ficticio'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $numero_candidato = trim($_POST['numero_candidato'] ?? '');
    $cargo = trim($_POST['cargo'] ?? '');
    $partido_ficticio = trim($_POST['partido_ficticio'] ?? '');

    if ($nome === '' || $numero_candidato === '') {
        $erro = 'Nome e número do candidato são obrigatórios.';
    } else {
        $check = $pdo->prepare("SELECT COUNT(*) FROM candidatos WHERE numero_candidato = :numero_candidato AND id_candidato != :id");
        $check->execute(['numero_candidato' => $numero_candidato, 'id' => $id]);
        if ($check->fetchColumn() > 0) {
            $erro = 'Já existe outro candidato com esse número.';
        } else {
            $stmt = $pdo->prepare("UPDATE candidatos SET nome = :nome, numero_candidato = :numero_candidato, cargo = :cargo, partido_ficticio = :partido_ficticio WHERE id_candidato = :id");
            $stmt->execute([
                'nome' => $nome,
                'numero_candidato' => $numero_candidato,
                'cargo' => $cargo,
                'partido_ficticio' => $partido_ficticio,
                'id' => $id,
            ]);
            redirecionar('candidatos.php?msg=' . urlencode('Candidato atualizado com sucesso!'));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar candidato - Sistema de Eleição</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Editar candidato #<?= (int)$id ?></h1>
    <p class="subtitulo">Atualize os dados do candidato</p>

    <div class="card">
        <?php if ($erro): ?>
            <div class="alert alert-erro"><?= limpar($erro) ?></div>
        <?php endif; ?>

        <form method="post" action="candidato_editar.php?id=<?= (int)$id ?>">
            <input type="hidden" name="id" value="<?= (int)$id ?>">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= limpar($nome) ?>" required>

            <label for="numero_candidato">Número do Candidato</label>
            <input type="text" id="numero_candidato" name="numero_candidato" value="<?= limpar($numero_candidato) ?>" required>

            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="cargo" value="<?= limpar($cargo) ?>">

            <label for="partido_ficticio">Partido (fictício)</label>
            <input type="text" id="partido_ficticio" name="partido_ficticio" value="<?= limpar($partido_ficticio) ?>">

            <button class="btn btn-primario" type="submit">Atualizar</button>
            <a class="btn btn-secundario" href="candidatos.php">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>
