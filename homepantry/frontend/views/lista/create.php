<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Lista $model */

$this->title = 'Create Lista';
$this->params['breadcrumbs'][] = ['label' => 'Listas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lista-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
