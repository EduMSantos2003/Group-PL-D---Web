<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Local $model */

$this->title = 'Create Local';
$this->params['breadcrumbs'][] = ['label' => 'Locals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="local-create">

    <h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
