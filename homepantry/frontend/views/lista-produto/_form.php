<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ListaProduto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lista-produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'id')->textInput() ?>-->

    <?= $form->field($model, 'idLista')->textInput() ?>

    <?= $form->field($model, 'idProduto')->textInput() ?>

    <?= $form->field($model, 'quantidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precoUnitario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subTotal')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
