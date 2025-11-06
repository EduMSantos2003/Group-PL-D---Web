<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\HistoricoPreco $model */

$this->title = 'Update Historico Preco: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Historico Precos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="historico-preco-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
