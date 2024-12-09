<?php
if(isset($_POST['botao'])){
    require_once __DIR__."/vendor/autoload.php";
    $produto = new Produto($_POST['descricao'],$_POST['categoria'],$_POST['valor']);
    $produto->save();
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action='formCad.php' method='POST'>
                <h2>Adicionar produto</h2>
                Descricao: <input name='descricao' type='text' required>
                <br>
                Categoria: <select name="categoria" id="categoria">
                        <option value="1">Nacional</option>
                        <option value="2">Importado</option>
                    </select>
                    <br>
                 Valor: <input name='valor' type='float' required>
                <br>
                <input type='submit' name='botao'>
            </form>
</body>
</html>