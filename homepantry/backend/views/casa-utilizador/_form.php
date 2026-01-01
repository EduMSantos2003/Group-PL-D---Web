<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Casa;

/** @var yii\web\View $this */
/** @var common\models\CasaUtilizador $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="casa-utilizador-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'utilizador_id')->dropDownList(
        ArrayHelper::map(
            User::find()->orderBy('username')->all(),
            'id',
            'username'
        ),
        ['prompt' => 'Selecione um utilizador']
    ) ?>

    <?= $form->field($model, 'casa_id')->dropDownList(
        ArrayHelper::map(
            Casa::find()->orderBy('nome')->all(),
            'id',
            'nome'
        ),
        ['prompt' => 'Selecione uma casa']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
