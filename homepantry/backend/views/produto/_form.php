<?php

use common\models\Categoria;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoria_id')->dropDownList(
        ArrayHelper::map(Categoria::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione uma categoria']
    ) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidade')->textInput() ?>

    <?= $form->field($model, 'preco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'validade')->widget(DatePicker::class, [
        'language' => 'pt',
        'dateFormat' => 'dd/MM/yyyy',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'Selecione a data de validade'
        ],
    ]) ?>

    <br>
    <!-- Campo de upload da imagem -->
    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn-create']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
