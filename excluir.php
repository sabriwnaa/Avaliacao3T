<?php
require_once __DIR__."/vendor/autoload.php";
$produto = produto::find($_GET['id']);
$produto->delete();
header("location:index.php");