<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Casa;

/** @var yii\web\View $this */
/** @var common\models\Local $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="local-form">

    <?php $form = ActiveForm::begin(); ?>
    <!-- Retirar o pedido do ID na página create de local
    <?= $form->field($model, 'id')->textInput() ?>
    <?= $form->field($model, 'idCasa')->textInput() ?>-->

    <?= $form->field($model, 'idCasa')->dropDownList(
        ArrayHelper::map(Casa::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione a casa']
    ) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
