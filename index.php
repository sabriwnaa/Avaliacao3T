<?php
require_once __DIR__."/vendor/autoload.php";
if(isset($_POST['botao'])){
    if($_POST['filtro'] == 2){
        $filtro = 1;
    } else if ($_POST['filtro'] == 3){
        $filtro = 2;
    } else {
        $filtro = 0;
    }
} else {
    $filtro = 0;
}
$produtos = Produto::findall();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Gastos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Sistema de Controle de Gastos</h1>
        </div>
        <div class='main'>
        <form action="index.php" method='post'>
            <select name="filtro" id="filtro">
                        <option value="1">Todos</option>
                        <option value="2">Apenas Nacionais</option>
                        <option value="3">Apenas Importados</option>
            </select>
            <input type='submit' name='botao'>
           
        </form>
        
        

            <?php
            
            foreach($produtos as $produto){
               if ($filtro == 0){
                echo "<div class='produto'>";
                    echo "<h2>{$produto->getDescricao()}</h2>";
                    if($produto->getCategoria() == 1){
                        echo "Nacional";
                    } else{
                        echo "Importado";
                    }
                    echo "<h2>
                    </h2>";
                    echo "<h2>{$produto->getValor()}</h2>";
                    echo "<a href='formEdit.php?id={$produto->getId()}'>Editar</a>
                            <a href='excluir.php?id={$produto->getId()}'>Excluir</a>";
                    echo "<div>";
               } else{
                if ($produto->getCategoria() == $filtro){
                    echo "<div class='produto'>";
                    echo "<h2>{$produto->getDescricao()}</h2>";
                    if($produto->getCategoria() == 1){
                        echo "Nacional";
                    } else{
                        echo "Importado";
                    }
                    echo "<h2>
                    </h2>";
                    echo "<h2>{$produto->getValor()}</h2>";
                    echo "<a href='formEdit.php?id={$produto->getId()}'>Editar</a>
                            <a href='excluir.php?id={$produto->getId()}'>Excluir</a>";
                    echo "<div>";
                   } 
               }
                
                
            }
            ?>


            <a href='formCad.php'>Adicionar Produto</a>

            <h2>Soma total das compras:</h2>
            <?php
            $soma = 0;
            foreach($produtos as $produto){
                if ($filtro == 0){
                    $soma += $produto->getValor();
                } else{
                    if ($produto->getCategoria() == $filtro){
                        $soma += $produto->getValor();
                    }
               
            }
        }
            echo $soma;
            ?>


            

        </div>

        <div class='footer'>
            <h3>Avaliação 3° trimestre em Programação III - Sabrina Hahn Melo </h3>
        </div>
        
    </div>
    
</body>
</html>