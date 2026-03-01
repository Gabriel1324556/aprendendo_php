<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de moeda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Conversor de Moedas</h1>
    <main>

        <?php
    //cotação do Euro copiada do Google
    
    
    
    $cotação = 6.18;
    
    //Quantidade de real que o usuário tem
    $real = $_REQUEST["din"] ?? 0;
    
    //Calculando o valor em Euro
    $euro = $real / $cotação ;
    
    //mostrar o resultado para o usuário
    echo "Seus R\$" . number_format($real,2)." equivalem a €" . number_format($euro,2);
    
    //formatação dde moeda com  internacionalização!
    
    
    /*
    ? Bliblioteca INTL (Internalization PHP) - para formatação de moeda, data, hora, etc. de acordo com a localidade do usuário.
    */
    $padrão = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
    
    echo "<p>O valor em real é: " . numfmt_format_currency($padrão, $real, "BRL") . " equivale a ". numfmt_format_currency($padrão, $euro, "EUR")."</p>";
    ?>
    <button onclick="javascript:history.go(-1)">Voltar</button>
    </main>
    
</body>
</html>