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
$nota1= $_GET['media1'];
$nota2= $_GET['media2'];
$nota3= $_GET['media3'];

$media = ($nota1+$nota2+$nota3)/3;
if($media>=6){
    $aprovacao = "O aluno foi aprovado.";
}
else{
    $aprovacao = "O aluno foi reprovado.";
}


echo "<main><H1>A media do aluno foi ".number_format($media, 2, ",", ".").". E ".$aprovacao."</H1></main> ";

?>

    
</body>
</html>