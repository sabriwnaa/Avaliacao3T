<?php
require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $valor = $_POST['valor'] ?? 0;

    if ($nome && $categoria && $valor > 0) {
        $produto = new Produto($nome, $categoria, (float)$valor);

        if ($produto->save()) {
            echo "Produto adicionado com sucesso!";
        } else {
            echo "Erro ao adicionar o produto.";
        }
    } else {
        echo "Dados inválidos.";
    }
}
?>
