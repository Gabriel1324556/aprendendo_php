<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>String.</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 

$rec_numero = $_GET['numero'];//receber numero

$str = strval($rec_numero);//transformar em texto

$abu = strlen((string)$rec_numero);//saber a quantidade de numeros

echo "<main><h1>
O valor recebido é: ".$rec_numero.". E assim ficou em string: \"".$str."\". Essa é a quantidade de números que você digitou: ".$abu.".</h1></main> ";

?>

    
</body>
</html>