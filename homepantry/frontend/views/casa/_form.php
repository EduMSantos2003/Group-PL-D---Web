<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Casa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="casa-form">

    <?php $form = ActiveForm::begin(); ?>

   <!-- <?= $form->field($model, 'id')->textInput() ?> -->

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dataCriacao')->textInput() ?>

    <?= $form->field($model, 'idUtilizadorPrincipal')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
