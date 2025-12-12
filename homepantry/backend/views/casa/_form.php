<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\db\Query;

/** @var yii\web\View $this */
/** @var common\models\Casa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="casa-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- NOME -->
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <!-- DATA CRIAÇÃO (NÃO EDITÁVEL) -->
    <?= $form->field($model, 'dataCriacao')->textInput([
        'value' => $model->isNewRecord ? date('Y-m-d ') : $model->dataCriacao,
        'readonly' => true
    ]) ?>

    <!-- UTILIZADOR PRINCIPAL (ADMIN OU GESTOR) -->
    <?= $form->field($model, 'utilizadorPrincipal_id')->dropDownList(
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
