<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Lista $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lista-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'utilizador_id')->textInput() ?>-->

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
