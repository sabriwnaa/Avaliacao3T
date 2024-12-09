<?php
require_once __DIR__ . "/vendor/autoload.php";

// Obter os parâmetros da URL
$filtro = $_GET['filtro'] ?? 1; // 1 = "Todos"
$pesquisar = $_GET['pesquisar'] ?? '';

// Filtrar produtos utilizando o método da classe Produto
$produtos = Produto::filter($pesquisar, $filtro);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Gastos</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function applyFilter() {
        const filtro = document.getElementById('filtro').value;
        const pesquisar = document.getElementById('pesquisar').value;

        // atualiza a URL sem recarregar a página
        const url = `index.php?filtro=${filtro}&pesquisar=${encodeURIComponent(pesquisar)}`;
        history.pushState({}, '', url);

        // Faz uma requisição assíncrona para carregar os dados
        fetch(url, { method: 'GET' })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // Atualiza a parte relevante da página (lista de produtos e total)
                document.querySelector('.listagem').innerHTML = doc.querySelector('.listagem').innerHTML;
                document.querySelector('.total').innerHTML = doc.querySelector('.total').innerHTML;
            })
            .catch(error => console.error('Erro ao carregar os dados:', error));
    }

    window.onload = () => {
        const filtroSelect = document.getElementById('filtro');
        const pesquisaInput = document.getElementById('pesquisar');

        filtroSelect.addEventListener('change', applyFilter);
        pesquisaInput.addEventListener('input', applyFilter);
    };
</script>


</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Controle de Gastos</h1>
            <h3>Gerencie suas compras nacionais e importadas e controle seus gastos</h3>
        </div>

        <div class="main">

            <h1 class='titulo'>Seu carrinho</h1>
            <div class='cabecalhos'>
                <div class="limitacoes">
                    <div>
                        <input id="pesquisar" class="pesquisa" type="text" placeholder="Nome do produto" value="<?= htmlspecialchars($pesquisar) ?>">
                    </div>
                    <div>
                        <select name="filtro" id="filtro" class='filtro'>
                            <option value="1" <?= $filtro == 1 ? 'selected' : '' ?>>Todos</option>
                            <option value="2" <?= $filtro == 2 ? 'selected' : '' ?>>Apenas Nacionais</option>
                            <option value="3" <?= $filtro == 3 ? 'selected' : '' ?>>Apenas Importados</option>
                        </select>
                    </div>
                </div>
                <div class="total">
                    <h2>Total</h2>
                    <h2>
                        <?php
                        $soma = Produto::calculateTotal($produtos);
                        echo $soma;
                        ?>
                    </h2>
                </div>
                <div class="cabecalho">
                    <h2>Produto</h2>
                    <h2>Valor</h2>
                </div>
            </div>

            <div class="listagem">
                <?php foreach ($produtos as $produto): ?>
                    <div class="produto">
                        <h2><?= htmlspecialchars($produto->getDescricao()) ?></h2>
                        <?= $produto->getCategoria() == 1 ? "Nacional" : "Importado" ?>
                        <h2><?= $produto->getValor() ?></h2>
                        <a href="formEdit.php?id=<?= $produto->getId() ?>">Editar</a>
                        <a href="excluir.php?id=<?= $produto->getId() ?>">Excluir</a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <a href="formCad.php">Adicionar Produto</a>
        </div>
    </div>
</body>
</html>
