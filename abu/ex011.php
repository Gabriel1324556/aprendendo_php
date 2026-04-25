<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formula Matemática</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 
/*
? Espaço amostral
todo (chamamos o espaço amostral, e indicamos por Ω um conjunto formado por todos os resulktados possíveis de um experimento aleatório.)

*/
$espaco_amostral = $_GET['resultado_possivel'];
$resultado_favoravel = $_GET['resultado_favoravel'];


    $probabilidade = ($resultado_favoravel / $espaco_amostral);
echo "<main>
<H1>
A probabilidade de ocorrer o resultado favorável é: ". ($probabilidade  * 100)."
</H1></main> ";

?>

    
</body>
</html>