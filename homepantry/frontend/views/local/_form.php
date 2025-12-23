<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var common\models\Local $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="local-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'casa_id')->dropDownList(
        ArrayHelper::map(\common\models\Casa::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione uma casa']
    ) ?>


    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
