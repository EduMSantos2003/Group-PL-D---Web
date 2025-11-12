<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CasaUtilizador $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="casa-utilizador-form">

    <?php $form = ActiveForm::begin(); ?>

   <!-- <?= $form->field($model, 'id')->textInput() ?> -->

    <?= $form->field($model, 'idUtilizador')->textInput() ?>

    <?= $form->field($model, 'idCasa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
