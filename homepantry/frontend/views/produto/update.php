<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
$this->registerCssFile('@web/css/produtos.css');

$this->title = 'Update Produto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

// --- Carregar imagens da pasta ---
$path = Yii::getAlias('@frontend/web/img-produtos');
$imagens = [];

if (is_dir($path)) {
    foreach (scandir($path) as $ficheiro) {
        if (preg_match('/\.(png|jpg|jpeg|webp)$/i', $ficheiro)) {
            $imagens[$ficheiro] = $ficheiro;
        }
    }
}

?>
<div class="produto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'imagens' => $imagens, // <-- ADICIONADO
    ]) ?>

</div>
