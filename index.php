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

    function toggleAddProduto() {
        const addProdutoDiv = document.getElementById('addProduto');
        addProdutoDiv.style.display = addProdutoDiv.style.display === 'none' ? 'block' : 'none';
    }

    function enviarProduto(event) {
        event.preventDefault();

        const formData = new FormData(document.getElementById('formAddProduto'));

        fetch('processaProduto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            alert(result); // Mensagem do backend
            location.reload(); // Recarregar página para atualizar a lista
        })
        .catch(error => console.error('Erro:', error));
    }
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
                        echo 'R$'.$soma.',00';
                        ?>
                    </h2>
                </div>

                
                <div class='addProduto'>
                    <button onclick="toggleAddProduto()">+ Adicionar produto</button>
                </div>

                <div id="addProduto" style="display: none;">
                    <form id="formAddProduto" onsubmit="enviarProduto(event)">
                        <div class='campos'>
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>
                        <div class='campos'>
                            <label for="categoria">Categoria</label>
                            <select id="categoria" name="categoria" required>
                                <option value="1">Nacional</option>
                                <option value="2">Importado</option>
                            </select>
                        </div>
                        <div class='campos'>
                            <label for="valor">Valor</label>
                            <input type="number" id="valor" name="valor" step="0.01" required>
                        </div>
                        <button type="submit">Salvar</button>
                    </form>
                </div>




                
            </div>

            <div class="listagem">
                <?php foreach ($produtos as $produto): ?>
                    <div class="produto">
                        <div class='todasInformacoes'>
                        <div class='informacoes'>
                            <h2><?= htmlspecialchars($produto->getDescricao()) ?></h2>
                            <h5><?= $produto->getCategoria() == 1 ? "Nacional" : "Importado" ?><h5>
                        </div>
                        <h3>R$<?= $produto->getValor() ?>,00</h3>
                        

                        </div>
                        <div class='opcoes'>
                            <a href="?editId=<?= $produto->getId() ?>">Editar</a>
                            <a href="excluir.php?id=<?= $produto->getId() ?>">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            
        </div>
    </div>
</body>
</html>
