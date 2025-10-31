<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\HistoricoPreco $model */

$this->title = 'Create Historico Preco';
$this->params['breadcrumbs'][] = ['label' => 'Historico Precos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historico-preco-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
