<?php
// ==========================================
// BACK-END: LÓGICA MATEMÁTICA E PROCESSAMENTO
// ==========================================

$resultado_html = "";

// Função para calcular Fatorial
function fatorial($n) {
    if ($n < 0) return 0;
    if ($n == 0 || $n == 1) return 1;
    $fat = 1;
    for ($i = $n; $i > 1; $i--) {
        $fat *= $i;
    }
    return $fat;
}

// Função para encontrar o Máximo Divisor Comum (MDC) - Útil para simplificar frações
function mdc($a, $b) {
    return $b == 0 ? $a : mdc($b, $a % $b);
}

// Função auxiliar para formatar resultados de probabilidade didaticamente
function formatarProbabilidade($numerador, $denominador) {
    if ($denominador == 0) return "<div class='alert alert-danger'>Erro: Divisão por zero (Espaço amostral não pode ser zero).</div>";
    
    $decimal = $numerador / $denominador;
    $porcentagem = $decimal * 100;
    
    // Tenta criar fração simplificada apenas se os números originais forem inteiros
    if (is_int($numerador) && is_int($denominador)) {
        $divisor_comum = mdc($numerador, $denominador);
        $num_simp = $numerador / $divisor_comum;
        $den_simp = $denominador / $divisor_comum;
        $fracao_str = ($den_simp == 1) ? $num_simp : "$num_simp / $den_simp";
    } else {
        $fracao_str = "N/A (Valores decimais)";
    }

    return "
        <div class='alert alert-success'>
            <h4 class='alert-heading'>Resultado Encontrado!</h4>
            <p><strong>Fração (Simplificada):</strong> {$fracao_str}</p>
            <p><strong>Decimal:</strong> " . number_format($decimal, 4, ',', '.') . "</p>
            <p><strong>Porcentagem:</strong> " . number_format($porcentagem, 2, ',', '.') . "%</p>
        </div>
    ";
}

// Processamento do Formulário via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operacao = $_POST['operacao'] ?? '';

    try {
        switch ($operacao) {
            case 'prob_simples':
                $n = filter_input(INPUT_POST, 'prob_n', FILTER_VALIDATE_FLOAT);
                $s = filter_input(INPUT_POST, 'prob_s', FILTER_VALIDATE_FLOAT);
                if ($n !== false && $s !== false && $s != 0) {
                    $resultado_html = formatarProbabilidade((int)$n, (int)$s);
                } else {
                    throw new Exception("Valores inválidos ou espaço amostral igual a zero.");
                }
                break;

            case 'prob_indep':
                $pa = filter_input(INPUT_POST, 'prob_pa', FILTER_VALIDATE_FLOAT);
                $pb = filter_input(INPUT_POST, 'prob_pb', FILTER_VALIDATE_FLOAT);
                if ($pa !== false && $pb !== false) {
                    $interseccao = $pa * $pb;
                    $resultado_html = formatarProbabilidade($interseccao, 1); // Denominador 1 para reusar a função
                    $resultado_html = str_replace("Fração (Simplificada): N/A (Valores decimais)", "Cálculo: P(A) &times; P(B) = $pa &times; $pb", $resultado_html);
                } else {
                    throw new Exception("Valores inválidos para as probabilidades.");
                }
                break;

            case 'prob_cond':
                $p_inter = filter_input(INPUT_POST, 'prob_inter', FILTER_VALIDATE_FLOAT);
                $p_b = filter_input(INPUT_POST, 'prob_p_b', FILTER_VALIDATE_FLOAT);
                if ($p_inter !== false && $p_b !== false && $p_b != 0) {
                    $resultado_html = formatarProbabilidade($p_inter, $p_b);
                } else {
                    throw new Exception("Valores inválidos ou probabilidade da condição igual a zero.");
                }
                break;

            case 'analise_comb':
                $tipo_comb = $_POST['tipo_comb'] ?? '';
                $n_comb = filter_input(INPUT_POST, 'comb_n', FILTER_VALIDATE_INT);
                $p_comb = filter_input(INPUT_POST, 'comb_p', FILTER_VALIDATE_INT);

                if ($n_comb === false || $n_comb < 0) {
                    throw new Exception("O valor de 'n' deve ser um inteiro positivo.");
                }

                if ($tipo_comb == 'permutacao') {
                    $res = fatorial($n_comb);
                    $resultado_html = "<div class='alert alert-success'><strong>Permutação P($n_comb) = $n_comb!</strong><br>Resultado: " . number_format($res, 0, '', '.') . " possibilidades.</div>";
                } else {
                    if ($p_comb === false || $p_comb < 0 || $p_comb > $n_comb) {
                        throw new Exception("O valor de 'p' deve ser positivo e não pode ser maior que 'n'.");
                    }
                    if ($tipo_comb == 'arranjo') {
                        $res = fatorial($n_comb) / fatorial($n_comb - $p_comb);
                        $resultado_html = "<div class='alert alert-success'><strong>Arranjo A($n_comb, $p_comb)</strong><br>Resultado: " . number_format($res, 0, '', '.') . " possibilidades. (A ordem importa)</div>";
                    } elseif ($tipo_comb == 'combinacao') {
                        $res = fatorial($n_comb) / (fatorial($p_comb) * fatorial($n_comb - $p_comb));
                        $resultado_html = "<div class='alert alert-success'><strong>Combinação C($n_comb, $p_comb)</strong><br>Resultado: " . number_format($res, 0, '', '.') . " possibilidades. (A ordem não importa)</div>";
                    }
                }
                break;
        }
    } catch (Exception $e) {
        $resultado_html = "<div class='alert alert-danger'><strong>Atenção:</strong> " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MathLab - Probabilidade e Combinatória</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .card { border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .form-section { display: none; /* Oculto por padrão, JS controla */ }
        .form-section.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h2 class="text-center text-primary mb-4">🔬 MathLab Calculadora</h2>
                
                <?= $resultado_html ?>

                <form method="POST" action="index.php" id="mathForm">
                    <div class="mb-4">
                        <label for="operacao" class="form-label fw-bold">O que você deseja calcular?</label>
                        <select class="form-select form-select-lg" name="operacao" id="operacao" required>
                            <option value="" disabled selected>Selecione uma operação...</option>
                            <option value="prob_simples" <?= (isset($_POST['operacao']) && $_POST['operacao'] == 'prob_simples') ? 'selected' : '' ?>>Probabilidade Simples</option>
                            <option value="prob_indep" <?= (isset($_POST['operacao']) && $_POST['operacao'] == 'prob_indep') ? 'selected' : '' ?>>Eventos Independentes</option>
                            <option value="prob_cond" <?= (isset($_POST['operacao']) && $_POST['operacao'] == 'prob_cond') ? 'selected' : '' ?>>Probabilidade Condicional</option>
                            <option value="analise_comb" <?= (isset($_POST['operacao']) && $_POST['operacao'] == 'analise_comb') ? 'selected' : '' ?>>Análise Combinatória</option>
                        </select>
                    </div>

                    <div id="sec_prob_simples" class="form-section p-3 border rounded mb-3 bg-light">
                        <h5 class="text-secondary">Probabilidade Simples (P = n/S)</h5>
                        <div class="mb-3">
                            <label class="form-label">Eventos Favoráveis (n)</label>
                            <input type="number" class="form-control" name="prob_n" placeholder="Ex: 1 (Tirar o número 4 em um dado)" value="<?= $_POST['prob_n'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Espaço Amostral (S - Total de Possibilidades)</label>
                            <input type="number" class="form-control" name="prob_s" placeholder="Ex: 6 (Lados do dado)" value="<?= $_POST['prob_s'] ?? '' ?>">
                        </div>
                    </div>

                    <div id="sec_prob_indep" class="form-section p-3 border rounded mb-3 bg-light">
                        <h5 class="text-secondary">Eventos Independentes (P(A e B) = P(A) * P(B))</h5>
                        <div class="mb-3">
                            <label class="form-label">Probabilidade do Evento A (em formato decimal, ex: 0.5)</label>
                            <input type="number" step="0.0001" class="form-control" name="prob_pa" value="<?= $_POST['prob_pa'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Probabilidade do Evento B (em formato decimal)</label>
                            <input type="number" step="0.0001" class="form-control" name="prob_pb" value="<?= $_POST['prob_pb'] ?? '' ?>">
                        </div>
                    </div>

                    <div id="sec_prob_cond" class="form-section p-3 border rounded mb-3 bg-light">
                        <h5 class="text-secondary">Probabilidade Condicional P(A|B)</h5>
                        <div class="mb-3">
                            <label class="form-label">Probabilidade da Intersecção P(A ∩ B) (em decimal)</label>
                            <input type="number" step="0.0001" class="form-control" name="prob_inter" value="<?= $_POST['prob_inter'] ?? '' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Probabilidade da Condição P(B) (em decimal)</label>
                            <input type="number" step="0.0001" class="form-control" name="prob_p_b" value="<?= $_POST['prob_p_b'] ?? '' ?>">
                        </div>
                    </div>

                    <div id="sec_analise_comb" class="form-section p-3 border rounded mb-3 bg-light">
                        <h5 class="text-secondary">Análise Combinatória</h5>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Agrupamento</label>
                            <select class="form-select" name="tipo_comb" id="tipo_comb">
                                <option value="permutacao" <?= (isset($_POST['tipo_comb']) && $_POST['tipo_comb'] == 'permutacao') ? 'selected' : '' ?>>Permutação Simples / Fatorial (n!)</option>
                                <option value="arranjo" <?= (isset($_POST['tipo_comb']) && $_POST['tipo_comb'] == 'arranjo') ? 'selected' : '' ?>>Arranjo Simples A(n,p)</option>
                                <option value="combinacao" <?= (isset($_POST['tipo_comb']) && $_POST['tipo_comb'] == 'combinacao') ? 'selected' : '' ?>>Combinação Simples C(n,p)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total de Elementos (n)</label>
                            <input type="number" class="form-control" name="comb_n" min="0" max="170" placeholder="Ex: 5" value="<?= $_POST['comb_n'] ?? '' ?>">
                            <small class="text-muted">Max: 170 (limite para evitar sobrecarga de memória no fatorial).</small>
                        </div>
                        <div class="mb-3" id="campo_p">
                            <label class="form-label">Elementos Escolhidos (p)</label>
                            <input type="number" class="form-control" name="comb_p" min="0" max="170" placeholder="Ex: 3" value="<?= $_POST['comb_p'] ?? '' ?>">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit" style="display: none;">Calcular Resultado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selectOperacao = document.getElementById("operacao");
        const selectTipoComb = document.getElementById("tipo_comb");
        const btnSubmit = document.getElementById("btnSubmit");

        // Mapeamento dos valores do select para os IDs das Divs
        const secMap = {
            "prob_simples": "sec_prob_simples",
            "prob_indep": "sec_prob_indep",
            "prob_cond": "sec_prob_cond",
            "analise_comb": "sec_analise_comb"
        };

        // Função para alternar a exibição dos campos principais
        function toggleFields() {
            // Oculta todas as seções
            document.querySelectorAll(".form-section").forEach(el => el.classList.remove("active"));
            
            const selected = selectOperacao.value;
            
            if (selected && secMap[selected]) {
                // Exibe a seção correspondente
                document.getElementById(secMap[selected]).classList.add("active");
                btnSubmit.style.display = "block"; // Mostra o botão calcular
            } else {
                btnSubmit.style.display = "none";
            }
            
            // Regra especial para análise combinatória
            if(selected === "analise_comb") {
                toggleCombFields();
            }
        }

        // Função para alternar campos específicos da combinatória
        function toggleCombFields() {
            const tipoComb = selectTipoComb.value;
            const campoP = document.getElementById("campo_p");
            
            // Permutação usa apenas 'n', então escondemos 'p'
            if (tipoComb === "permutacao") {
                campoP.style.display = "none";
            } else {
                campoP.style.display = "block";
            }
        }

        // Listeners de eventos
        selectOperacao.addEventListener("change", toggleFields);
        selectTipoComb.addEventListener("change", toggleCombFields);

        // Executa na inicialização da página para manter estado após o POST (re-render)
        toggleFields();
    });
</script>

</body>
</html>