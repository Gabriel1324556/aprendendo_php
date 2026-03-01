<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
        $num_Recebido = $_GET["num"] ?? 0;
        $num_Antecessor = $num_Recebido - 1;
        $num_Sucessor = $num_Recebido + 1;
    
        echo "O antecessor de $num_Recebido é <strong>$num_Antecessor</strong>\n";
        echo "O sucessor de $num_Recebido é <strong>$num_Sucessor</strong>\n";
        
    ?>
    
    
</body>
</html>