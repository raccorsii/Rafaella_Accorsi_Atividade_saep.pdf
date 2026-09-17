<?php
require 'db.php';
require 'functions.php';

$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM candidatos WHERE nome LIKE :busca OR numero_candidato LIKE :busca OR cargo LIKE :busca OR partido_ficticio LIKE :busca ORDER BY id_candidato DESC");
    $stmt->execute(['busca' => '%' . $busca . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM candidatos ORDER BY id_candidato DESC");
}
$candidatos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos - Sistema de Eleição</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Sistema de Eleição</h1>
    <p class="subtitulo">CRUD de Eleitores e Candidatos</p>

    <div class="abas">
        <a class="aba" href="index.php">Eleitores</a>
        <a class="aba ativa" href="candidatos.php">Candidatos</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-sucesso"><?= limpar($_GET['msg']) ?></div>
    <?php endif; ?>

    <div class="topo">
        <form class="busca" method="get" action="candidatos.php">
            <input type="text" name="busca" placeholder="Buscar por nome, número, cargo ou partido..." value="<?= limpar($busca) ?>">
            <button class="btn btn-secundario" type="submit">Buscar</button>
            <?php if ($busca !== ''): ?>
                <a class="btn btn-secundario" href="candidatos.php">Limpar</a>
            <?php endif; ?>
        </form>
        <a class="btn btn-primario" href="candidato_criar.php">+ Novo candidato</a>
    </div>

    <?php if (count($candidatos) === 0): ?>
        <div class="card vazio">Nenhum candidato encontrado.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Número</th>
                    <th>Cargo</th>
                    <th>Partido (fictício)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidatos as $c): ?>
                    <tr>
                        <td>#<?= (int)$c['id_candidato'] ?></td>
                        <td><?= limpar($c['nome']) ?></td>
                        <td><span class="badge"><?= limpar($c['numero_candidato']) ?></span></td>
                        <td><?= limpar($c['cargo'] ?? '-') ?></td>
                        <td><?= limpar($c['partido_ficticio'] ?? '-') ?></td>
                        <td class="acoes">
                            <a class="btn btn-secundario" href="candidato_editar.php?id=<?= (int)$c['id_candidato'] ?>">Editar</a>
                            <a class="btn btn-perigo" href="candidato_excluir.php?id=<?= (int)$c['id_candidato'] ?>"
                               onclick="return confirm('Tem certeza que deseja excluir este candidato?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
