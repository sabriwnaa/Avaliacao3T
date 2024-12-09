<?php
if(isset($_GET['id'])){
    require_once __DIR__."/vendor/autoload.php";
    $produto = Produto::find($_GET['id']);
}
if(isset($_POST['botao'])){
    require_once __DIR__."/vendor/autoload.php";
    $produto = new Produto($_POST['descricao'],$_POST['categoria'],$_POST['valor']);
    $produto->setId($_POST['idProduto']);
    $produto->save();
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Produto</title>
</head>
<body>
    <form action='formEdit.php' method='POST'>
        <?php
            echo "Descrição: <input name='descricao' value='{$produto->getDescricao()}' type='text' required>";
            echo "<br>";
            echo "Categoria: <select name='categoria' id='categoria'>
                        <option value='1'>Nacional</option>
                        <option value='2'>Importado</option>
                    </select>";
            echo "<br>";
            echo "Valor: <input name='valor' value={$produto->getValor()} type='float' required>";
            echo "<br>";
            echo "<input name='idProduto' value={$produto->getId()} type='hidden'>";
        ?>
        <br>
        <input type='submit' name='botao'>
    </form>
</body>
</html>

