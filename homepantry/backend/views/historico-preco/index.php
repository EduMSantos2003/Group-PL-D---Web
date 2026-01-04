<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Produto;

$this->title = 'Histórico de Preços';
$this->params['breadcrumbs'][] = $this->title;

$graficoUrl = Url::to(['dados-grafico']);
$produtos = Produto::find()->orderBy('nome')->all();

// Chart.js
$this->registerJsFile(
        'https://cdn.jsdelivr.net/npm/chart.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
);
?>

<div class="historico-preco-index">

    <h1></h1>

    <p class="text-muted">
        Selecione um produto para visualizar a evolução do preço ao longo do tempo.
    </p>

    <?= Html::dropDownList(
            'produto',
            null,
            ArrayHelper::map($produtos, 'id', 'nome'),
            [
                    'prompt' => 'Selecione um produto',
                    'id' => 'produto-select',
                    'class' => 'form-control mb-4',
            ]
    ) ?>

    <canvas id="graficoPreco" height="120"></canvas>

</div>

<?php
$js = <<<JS
let chart = null;

$('#produto-select').on('change', function () {
    const produtoId = $(this).val();

    if (!produtoId) return;

    $.getJSON('$graficoUrl', { produto_id: produtoId }, function (response) {

        const ctx = document.getElementById('graficoPreco').getContext('2d');

        if (chart) {
            chart.destroy();
        }

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: response.labels,
                datasets: [{
                    label: 'Preço (€)',
                    data: response.data,
                    borderWidth: 2,
                    tension: 0.3,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    });
});
JS;

$this->registerJs($js);
?>
