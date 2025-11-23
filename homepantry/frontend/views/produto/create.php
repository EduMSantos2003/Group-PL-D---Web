<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->registerCssFile('@web/css/produtos.css');

$this->title = 'Create Produto';
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// -------------------------
// Carregar imagens da pasta (aponta para frontend/web/img-produtos)
$path = Yii::getAlias('@frontend/web/img/produtos');
$imagens = [];

if (is_dir($path)) {
    foreach (scandir($path) as $ficheiro) {
        if (preg_match('/\.(png|jpg|jpeg|webp|gif)$/i', $ficheiro)) {
            $imagens[$ficheiro] = $ficheiro;
        }
    }
}

// garantir que ao criar não aparece preview vazio
$model->imagem = $model->imagem ?? '';

?>
<div class="produto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'imagens' => $imagens,
    ]) ?>

</div>
