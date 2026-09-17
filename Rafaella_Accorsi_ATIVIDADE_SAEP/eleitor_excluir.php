<?php
require 'db.php';
require 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM eleitor WHERE id_eleitor = :id");
    $stmt->execute(['id' => $id]);
    redirecionar('index.php?msg=' . urlencode('Eleitor excluído com sucesso!'));
}

redirecionar('index.php');
