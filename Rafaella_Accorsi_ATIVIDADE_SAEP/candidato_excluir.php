<?php
require 'db.php';
require 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM candidatos WHERE id_candidato = :id");
    $stmt->execute(['id' => $id]);
    redirecionar('candidatos.php?msg=' . urlencode('Candidato excluído com sucesso!'));
}

redirecionar('candidatos.php');
