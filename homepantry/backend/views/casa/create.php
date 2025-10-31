<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Casa $model */

$this->title = 'Create Casa';
$this->params['breadcrumbs'][] = ['label' => 'Casas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="casa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
