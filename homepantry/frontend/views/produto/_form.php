<?php

use yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Categoria;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var array $imagens */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Categoria -->
    <?= $form->field($model, 'idCategoria')->dropDownList(
        ArrayHelper::map(Categoria::find()->all(), 'id', 'nome'),
        ['prompt' => 'Selecione uma categoria']
    ) ?>

    <!-- Nome -->
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <!-- Dropdown de imagem -->
    <?= $form->field($model, 'imagem')->dropDownList(
        $imagens,
        [
            'prompt' => 'Selecione uma imagem',
            'id' => 'imagem-dropdown'
        ]
    ) ?>

    <!-- Preview -->
    <div id="preview-wrapper" style="margin:10px 0;">
        <img id="preview-img"
             src="<?= $model->imagem ? Yii::getAlias('@web') . '/img/produtos/' . $model->imagem : '' ?>"
             style="max-width:150px; border:1px solid #ccc; padding:4px; <?= $model->imagem ? '' : 'display:none;' ?>">

    </div>

    <!-- Descrição -->
    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <!-- Unidade -->
    <?= $form->field($model, 'unidade')->textInput() ?>

    <!-- Preço -->
    <?= $form->field($model, 'preco')->textInput() ?>

    <!-- Validade -->
    <?= $form->field($model, 'validade')->textInput() ?>

    <!-- Botão -->
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let baseUrl = "<?= Yii::getAlias('@web') ?>";
        let dropdown = document.getElementById("imagem-dropdown");
        let previewImg = document.getElementById("preview-img");

        if (dropdown.value) {
            previewImg.src = baseUrl + "/img/produtos/" + dropdown.value;
            previewImg.style.display = "block";
        }

        dropdown.addEventListener("change", function () {
            if (dropdown.value) {
                previewImg.src = baseUrl + "/img/produtos/" + dropdown.value;
                previewImg.style.display = "block";
            } else {
                previewImg.style.display = "none";
            }
        });

    });
</script>

