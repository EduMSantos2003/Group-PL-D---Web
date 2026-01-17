<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\Tarefa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feito')->checkbox() ?>


    <!-- UTILIZADOR PRINCIPAL (ADMIN OU GESTOR) -->
    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(
            User::find()
                ->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->where(['auth_assignment.item_name' => ['admin', 'gestorCasa']])
                ->all(),
            'id',
            'username'
        ),
        ['prompt' => 'Selecione o utilizador responsável']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
