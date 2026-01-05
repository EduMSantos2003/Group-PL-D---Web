<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CasaUtilizador $model */

$this->title = 'Create Casa Utilizador';
$this->params['breadcrumbs'][] = ['label' => 'Casa Utilizadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="casa-utilizador-create">

    <h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
