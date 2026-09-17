<?php
function limpar($valor) {
    return htmlspecialchars(trim((string)$valor), ENT_QUOTES, 'UTF-8');
}

function redirecionar($url) {
    header('Location: ' . $url);
    exit;
}
