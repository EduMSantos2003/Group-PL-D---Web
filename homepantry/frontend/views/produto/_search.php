<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProdutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idCategoria') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'unidade') ?>

    <?php // echo $form->field($model, 'preco') ?>

    <?php // echo $form->field($model, 'validade') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
