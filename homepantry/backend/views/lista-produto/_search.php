<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ListaProdutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lista-produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'lista_id') ?>

    <?= $form->field($model, 'produto_id') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?= $form->field($model, 'precoUnitario') ?>

    <?php // echo $form->field($model, 'subTotal') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
