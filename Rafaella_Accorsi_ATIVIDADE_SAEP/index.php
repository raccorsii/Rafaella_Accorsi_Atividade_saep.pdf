<?php
require 'db.php';
require 'functions.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM eleitor WHERE nome LIKE :busca OR numero_titulo LIKE :busca OR cidade LIKE :busca ORDER BY id_eleitor DESC");
    $stmt->execute(['busca' => '%' . $busca . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM eleitor ORDER BY id_eleitor DESC");
}
$eleitores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eleitores - Sistema de Eleição</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Sistema de Eleição</h1>
    <p class="subtitulo">CRUD de Eleitores e Candidatos</p>

    <div class="abas">
        <a class="aba ativa" href="index.php">Eleitores</a>
        <a class="aba" href="candidatos.php">Candidatos</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-sucesso"><?= limpar($_GET['msg']) ?></div>
    <?php endif; ?>

    <div class="topo">
        <form class="busca" method="get" action="index.php">
            <input type="text" name="busca" placeholder="Buscar por nome, título ou cidade..." value="<?= limpar($busca) ?>">
            <button class="btn btn-secundario" type="submit">Buscar</button>
            <?php if ($busca !== ''): ?>
                <a class="btn btn-secundario" href="index.php">Limpar</a>
            <?php endif; ?>
        </form>
        <a class="btn btn-primario" href="eleitor_criar.php">+ Novo eleitor</a>
    </div>

    <?php if (count($eleitores) === 0): ?>
        <div class="card vazio">Nenhum eleitor encontrado.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Número do Título</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eleitores as $e): ?>
                    <tr>
                        <td>#<?= (int)$e['id_eleitor'] ?></td>
                        <td><?= limpar($e['nome']) ?></td>
                        <td><span class="badge"><?= limpar($e['numero_titulo']) ?></span></td>
                        <td><?= limpar($e['cidade'] ?? '-') ?></td>
                        <td class="acoes">
                            <a class="btn btn-secundario" href="eleitor_editar.php?id=<?= (int)$e['id_eleitor'] ?>">Editar</a>
                            <a class="btn btn-perigo" href="eleitor_excluir.php?id=<?= (int)$e['id_eleitor'] ?>"
                               onclick="return confirm('Tem certeza que deseja excluir este eleitor?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
