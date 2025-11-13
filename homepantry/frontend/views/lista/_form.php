<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Utilizador;

/** @var yii\web\View $this */
/** @var common\models\Lista $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="lista-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Retirar o pedido do ID na página create de local
    <?= $form->field($model, 'id')->textInput() ?> -->

    <!-- <?= $form->field($model, 'idUtilizador')->textInput() ?> -->
    <?= $form->field($model, 'idUtilizador')->dropDownList(
        ArrayHelper::map(Utilizador::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione um utilizador']
    ) ?>
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'totalEstimado')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dataCriacao')->textInput() ?> -->

    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
