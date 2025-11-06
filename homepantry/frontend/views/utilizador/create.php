<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Utilizador $model */

$this->title = 'Create Utilizador';
$this->params['breadcrumbs'][] = ['label' => 'Utilizadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utilizador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
