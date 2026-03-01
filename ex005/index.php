<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operações aritmetricas </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Operações Aritméticas</h1>
    <?php 
    $a = 10;
    $b = 2;

    echo "<p>Soma: Soma um número" . ($a + $b) . "</p>";
    echo "<p>Subtração:  Subtrai um número" . ($a - $b) . "</p>";
    echo "<p>Multiplicação: Mutiplica um número" . ($a * $b) . "</p>";
    echo "<p>Divisão: Divide um número" . ($a / $b) . "</p>";
    echo "<p>Módulo: Pega o resto da divisão" . $a . " por " . $b . ": " . ($a % $b) . "</p>";
    echo "<p>Exponenciação: Mutiplica um número  por ele mesmo" . ($a ** $b) . "</p>";
    ?>
    <h2>outras operações aritméticas</h2>
    <?php

    echo "<p> abs: Valor absoluto de um valor" . abs($a) . "</p>";
    echo "<p>base_convert: Conversor de números" . base_convert(10, 10, 2 ) . "</p>";
    echo "<p>ceil, floor ,round: Funções de arredondamento: " . ceil($a) . ", " . floor($a) . ", " . round($a) . "</p>";
    echo "<p>hypot: Calcula a hipotenusa de um triangulo retangulo: " . hypot(3,4) . "</p>";
    echo "<p>intdiv: Divide dois números inteiros e retorna o resultado inteiro: " . intdiv(10, 2) . "</p>";
    echo "<p>max, min: Retorna o maior e o menor valor de uma lista de argumentos: " . max(1, 5, 10, 3) . ", " . min(1, 5, 10, 3) . "</p>";
    echo "<p>pi: Retorna o valor de pi: " . pi() . "</p>";
    echo "<p>pow: Calcula a potência de um número: " . pow(2, 3) . "</p>";
    echo "<p>sin, cos, tan: Funções trigonométricas: " . sin(pi()/2) . ", " . cos(0) . ", " . tan(pi()/4) . "</p>";
    echo "<p>sqrt: Calcula a raiz quadrada de um número: " . sqrt(16) . "</p>";
    ?>




    
</body>
</html>