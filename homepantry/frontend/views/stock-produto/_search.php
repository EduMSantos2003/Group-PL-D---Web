<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\StockProdutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="stock-produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'produto_id') ?>

    <?= $form->field($model, 'utilizador_id') ?>

    <?= $form->field($model, 'local_id') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?php // echo $form->field($model, 'validade') ?>

    <?php // echo $form->field($model, 'preco') ?>

    <?php // echo $form->field($model, 'dataCriacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
