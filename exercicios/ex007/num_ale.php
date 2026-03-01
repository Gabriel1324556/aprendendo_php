<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
    <h1>Trabalhando com numeros aleatórios</h1>
    
        <form action="num_ale.php" method="get">
            <h2>Gerando um número aleatório entre 0 e 100 </h2>
            <h3></h3>
            <input type="submit" value="Gerar outro número">
            
        </form>
        <?php
    $MIN = 0;
    $MAX = 100;
    
    $num = mt_rand($MIN,$MAX);
    /*
    ? rand() = 1951 - Linear Congrential Gererator 
    * mt_rand() = 1997 - Mersenne Twister
    ? A partir do PHP 7.1, rand() é um simples apontamento para mt_randon()
    * rand_int() gera números aleatórios criptograficamemte seguros    
    */
    echo "<p>Gerando um número aleatório enter $MIN e $MAX... <br> O valor gerado foi <strong>$num</strong></p>"
    ?>
    </main>




</body>
</html>