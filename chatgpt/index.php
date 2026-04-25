<?php
// Função para calcular máximo divisor comum (para simplificar frações)
function gcd($a, $b) {
    return ($b == 0) ? $a : gcd($b, $a % $b);
}
// Função para calcular fatorial de um número
function fatorial($x) {
    if ($x <= 1) return 1;
    $f = 1;
    for ($i = 2; $i <= $x; $i++) {
        $f *= $i;
    }
    return $f;
}

// Inicializa mensagem de resultado
$resultMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = $_POST['operation']; // Operação escolhida pelo usuário
    switch ($operation) {
        case 'probabilidade_simples':
            // Obtém n (favoráveis) e S (espaço amostral)
            $n = isset($_POST['num_favoraveis']) ? floatval($_POST['num_favoraveis']) : null;
            $S = isset($_POST['espaco_amostral']) ? floatval($_POST['espaco_amostral']) : null;
            if ($n === null || $S === null || $S == 0) {
                $resultMessage = '<div class="alert alert-danger">Entrada inválida ou espaço amostral zero.</div>';
            } else {
                // Calcula P = n/S
                $P = $n / $S;
                // Simplifica a fração n/S
                $num = intval($n);
                $den = intval($S);
                $g = gcd($num, $den);
                $fracNum = $num / $g;
                $fracDen = $den / $g;
                $fracStr = "$fracNum/$fracDen";
                $decimal = number_format($P, 4);
                $percent = number_format($P * 100, 2) . '%';
                // Monta a mensagem de resultado
                $resultMessage = "<p>Probabilidade Simples: P = n/S = $num/$den = $fracStr = $decimal = $percent</p>";
            }
            break;
        case 'eventos_independentes':
            // Obtém P(A) e P(B)
            $pA = isset($_POST['probA']) ? floatval($_POST['probA']) : null;
            $pB = isset($_POST['probB']) ? floatval($_POST['probB']) : null;
            if ($pA === null || $pB === null) {
                $resultMessage = '<div class="alert alert-danger">Entrada inválida para eventos independentes.</div>';
            } else {
                // Calcula P(A∩B) = P(A)*P(B)
                $pAB = $pA * $pB;
                $decimal = number_format($pAB, 4);
                $percent = number_format($pAB * 100, 2) . '%';
                $resultMessage = "<p>Eventos Independentes: P(A)=$pA, P(B)=$pB → P(A∩B) = $decimal ($percent)</p>";
            }
            break;
        case 'probabilidade_condicional':
            // Obtém P(A∩B) e P(B)
            $pAB = isset($_POST['probAB']) ? floatval($_POST['probAB']) : null;
            $pB = isset($_POST['probB_cond']) ? floatval($_POST['probB_cond']) : null;
            if ($pAB === null || $pB === null || $pB == 0) {
                $resultMessage = '<div class="alert alert-danger">Entrada inválida ou P(B) = 0.</div>';
            } else {
                // Calcula P(A|B) = P(A∩B) / P(B)
                $pA_cond_B = $pAB / $pB;
                $decimal = number_format($pA_cond_B, 4);
                $percent = number_format($pA_cond_B * 100, 2) . '%';
                $resultMessage = "<p>Probabilidade Condicional: P(A∩B)=$pAB, P(B)=$pB → P(A|B) = $decimal ($percent)</p>";
            }
            break;
        case 'combinatoria':
            // Obtém tipo (fatorial, arranjo, combinação), n e p
            $tipo = $_POST['comb_tipo'];
            $n = isset($_POST['n_combi']) ? intval($_POST['n_combi']) : null;
            $p = isset($_POST['p_combi']) ? intval($_POST['p_combi']) : null;
            if ($n === null || $n < 0 || ($tipo != 'fatorial' && ($p === null || $p < 0 || $p > $n))) {
                $resultMessage = '<div class="alert alert-danger">Entrada inválida na análise combinatória.</div>';
            } else {
                if ($tipo === 'fatorial') {
                    $res = fatorial($n);
                    $resultMessage = "<p>Fatorial: $n! = $res</p>";
                } elseif ($tipo === 'arranjo') {
                    $res = fatorial($n) / fatorial($n - $p);
                    $resultMessage = "<p>Arranjo Simples: A($n,$p) = $res</p>";
                } elseif ($tipo === 'combinacao') {
                    $res = fatorial($n) / (fatorial($p) * fatorial($n - $p));
                    $resultMessage = "<p>Combinação Simples: C($n,$p) = $res</p>";
                }
            }
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Probabilidade e Análise Combinatória</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
    <h1 class="mb-4">Calculadora de Probabilidade e Combinatória</h1>
    <form method="post" id="calcForm">
        <!-- Seleção de operação -->
        <div class="form-group">
            <label for="operation">Escolha a operação:</label>
            <select class="form-control" name="operation" id="operation">
                <option value="" selected disabled>-- Selecione --</option>
                <option value="probabilidade_simples">Probabilidade Simples</option>
                <option value="eventos_independentes">Eventos Independentes</option>
                <option value="probabilidade_condicional">Probabilidade Condicional</option>
                <option value="combinatoria">Análise Combinatória</option>
            </select>
        </div>
        <!-- Campos para cada tipo de cálculo -->
        <div class="form-group" id="fields_probabilidade_simples" style="display:none;">
            <label>Probabilidade Simples:</label>
            <input type="number" step="1" class="form-control mb-2" name="num_favoraveis" placeholder="Casos favoráveis (n)">
            <input type="number" step="1" class="form-control" name="espaco_amostral" placeholder="Espaço amostral (S)">
        </div>
        <div class="form-group" id="fields_eventos_independentes" style="display:none;">
            <label>Eventos Independentes:</label>
            <input type="number" step="0.0001" class="form-control mb-2" name="probA" placeholder="Probabilidade de A (ex: 0.5)">
            <input type="number" step="0.0001" class="form-control" name="probB" placeholder="Probabilidade de B (ex: 0.3)">
        </div>
        <div class="form-group" id="fields_probabilidade_condicional" style="display:none;">
            <label>Probabilidade Condicional:</label>
            <input type="number" step="0.0001" class="form-control mb-2" name="probAB" placeholder="P(A ∩ B)">
            <input type="number" step="0.0001" class="form-control" name="probB_cond" placeholder="P(B)">
        </div>
        <div class="form-group" id="fields_combinatoria" style="display:none;">
            <label>Análise Combinatória:</label>
            <select class="form-control mb-2" name="comb_tipo" id="comb_tipo">
                <option value="" selected disabled>-- Selecione --</option>
                <option value="fatorial">Fatorial (n!)</option>
                <option value="arranjo">Arranjo Simples (A(n,p))</option>
                <option value="combinacao">Combinação Simples (C(n,p))</option>
            </select>
            <input type="number" step="1" class="form-control mb-2" name="n_combi" id="n_combi" placeholder="Total de elementos (n)">
            <input type="number" step="1" class="form-control" name="p_combi" id="p_combi" placeholder="Elementos escolhidos (p)">
        </div>
        <button type="submit" class="btn btn-primary">Calcular</button>
    </form>
    <!-- Exibe o resultado -->
    <?php
        if (!empty($resultMessage)) {
            echo '<hr>' . $resultMessage;
        }
    ?>
</div>
<script>
// Controla visibilidade dos campos com base na seleção
function showFields() {
    var op = document.getElementById('operation').value;
    // Ocultar todos os grupos inicialmente
    document.getElementById('fields_probabilidade_simples').style.display = 'none';
    document.getElementById('fields_eventos_independentes').style.display = 'none';
    document.getElementById('fields_probabilidade_condicional').style.display = 'none';
    document.getElementById('fields_combinatoria').style.display = 'none';
    // Mostrar grupo correspondente
    if (op === 'probabilidade_simples') {
        document.getElementById('fields_probabilidade_simples').style.display = 'block';
    } else if (op === 'eventos_independentes') {
        document.getElementById('fields_eventos_independentes').style.display = 'block';
    } else if (op === 'probabilidade_condicional') {
        document.getElementById('fields_probabilidade_condicional').style.display = 'block';
    } else if (op === 'combinatoria') {
        document.getElementById('fields_combinatoria').style.display = 'block';
        showCombinatoriaFields();
    }
}
// Visibilidade específica dentro de Análise Combinatória
function showCombinatoriaFields() {
    var tipo = document.getElementById('comb_tipo').value;
    var nField = document.getElementById('n_combi');
    var pField = document.getElementById('p_combi');
    if (tipo === 'fatorial') {
        nField.style.display = 'block';
        pField.style.display = 'none';
    } else if (tipo === 'arranjo' || tipo === 'combinacao') {
        nField.style.display = 'block';
        pField.style.display = 'block';
    }
}
// Associa eventos
document.getElementById('operation').addEventListener('change', showFields);
document.getElementById('comb_tipo').addEventListener('change', showCombinatoriaFields);
window.onload = function() {
    showFields();
    showCombinatoriaFields();
};
</script>
</body>
</html>
