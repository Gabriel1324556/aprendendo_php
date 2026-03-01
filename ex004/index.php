<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDEM DE PRECEDÊNCIA</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ORDEM DE PRECEDÊNCIA</h1>
    <h2>()</h2>
    <h3>**</h3>
    <h4>* / %</h4>
    <h5>+ -</h5>

    <?php 
    $var = 50 / (2+3)** 2;
    echo $var;
    ?>
    
</body>
</html>