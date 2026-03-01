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

        /*
        todo //Pegando a cotação do site do banco central
        */


        $inicio = date("m-d-Y", strtotime("-7 days"));
        $fim = date("m-d-Y"); 
        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda=\'EUR\'&@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

        $dados = json_decode(file_get_contents($url), true);



        $cotação = $dados["value"][0]["cotacaoCompra"];



    
        //Quantidade de real que o usuário tem
        $real = $_REQUEST["din"] ?? 0;
    
        //Calculando o valor em Euro
        $euro = $real / $cotação ;

        //Calculando os centavos do Real
        $centavos_real = $_REQUEST["din"] ?? 0;

        $int = (int) $centavos_real;
        $fra = $centavos_real - $int;
        //Calculando os centavos do Euro
        $int_euro = (int) $euro;
        $centavos_euro = $euro - $int_euro;


        //mostrar o resultado para o usuário
        echo "Seus R\$" . number_format($real,2,",", ".")." equivalem a €" . number_format($euro,2,",", ".");
    
        //formatação de moeda com  internacionalização!
        
        
        /*
        ? Bliblioteca INTL (Internalization PHP) - para formatação de moeda, data, hora, etc. de acordo com a localidade do usuário.
        */
        $padrão = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
        
        echo "<ul><li><p>O valor em real é: <strong>" . numfmt_format_currency($padrão, $int, "BRL") ."</strong> e os Centavos são <strong>" . number_format($fra, 2, ",", ".") . "</strong> equivale a <strong>". numfmt_format_currency($padrão, $int_euro, "EUR")."</strong> e os Centavos do Euro são <strong>". number_format($centavos_euro, 2, ",", ".") . "</strong></p></li></ul>";





    
        ?>
        <button onclick="javascript:history.go(-1)">Voltar</button>
    </main>
    
</body>
</html>