<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <header>
        <h1>Resultado do processamento</h1>
    </header>
    <main>
        <?php 
            $nome = $_REQUEST["nome"];
            $sobrenome = $_REQUEST["sobrenome"];
            echo "<p>Olá, é um prazer te conhecer <strong>$nome $sobrenome</strong>! Este é o meu site</p>";
        ?>
        <a href="javascript:history.go(-1)">Voltar para a página anterior</a>
    </main>

    
</body>
</html>