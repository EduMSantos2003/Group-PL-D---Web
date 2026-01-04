<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Produto;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\StockProduto $model */
/** @var yii\widgets\ActiveForm $form */

$produtos = ArrayHelper::map(
        Produto::find()->all(),
        'id',
        'nome'
);

?>

<div class="stock-produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'produto_id')->dropDownList(
            $produtos,
            [
                    'prompt' => 'Seleciona um produto',
                    'onchange' => 'atualizarPreco();'
            ]
    ) ?>

    <?= $form->field($model, 'local_id')->dropDownList(
            $locaisList,
            ['prompt' => 'Selecione um local']
    ) ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'quantidade')->textInput([
                'oninput' => 'atualizarPreco();'
        ]) ?>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$precoUrl = \yii\helpers\Url::to(['/stock-produto/get-preco']);
$js = <<<JS
function atualizarPreco() {
    let produtoId = $('#stockproduto-produto-id').val();
    let quantidade = parseFloat($('#stockproduto-quantidade').val());

    if (!produtoId || !quantidade || quantidade <= 0) {
        $('#stockproduto-preco').val('');
        return;
    }

    $.ajax({
        url: '$precoUrl',
        dataType: 'json',
        data: { id: produtoId },
        success: function (data) {
            if (data.preco !== null) {
                let total = parseFloat(data.preco) * quantidade;
                $('#stockproduto-preco').val(total.toFixed(2));
            }
        }
    });
}

$(document).ready(function () {
    atualizarPreco();
});
JS;

$this->registerJs($js);
?>


