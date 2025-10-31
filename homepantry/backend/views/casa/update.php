<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Casa $model */

$this->title = 'Update Casa: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Casas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="casa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
