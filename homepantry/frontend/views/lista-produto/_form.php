<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Produto;

/** @var $model common\models\ListaProduto */
/** @var $lista common\models\Lista */

$produtos = ArrayHelper::map(
    Produto::find()->all(),
    'id',
    'nome'
);
?>

<div class="lista-produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'produto_id')->dropDownList(
        $produtos,
        ['prompt' => 'Seleciona um produto']
    ) ?>

    <?= $form->field($model, 'quantidade')->input('number', [
        'step' => '0.01',
        'min' => 0.01
    ]) ?>

    <?= Html::activeHiddenInput($model, 'lista_id') ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Adicionar', ['class' => 'btn btn-success']) ?>
        <?= Html::a(
            'Cancelar',
            ['lista-produto/index', 'lista_id' => $lista->id],
            ['class' => 'btn btn-secondary ms-2']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
