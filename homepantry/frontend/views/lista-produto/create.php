<?php

use yii\helpers\Html;

/** @var $model common\models\ListaProduto */
/** @var $lista common\models\Lista */

$this->title = 'Adicionar produto à lista';
$this->params['breadcrumbs'][] = ['label' => 'Listas', 'url' => ['lista/index']];
$this->params['breadcrumbs'][] = [
    'label' => $lista->nome,
    'url' => ['lista-produto/index', 'lista_id' => $lista->id]
];
$this->params['breadcrumbs'][] = 'Adicionar produto';
?>

<h2><?= Html::encode($this->title) ?></h2>

<?= $this->render('_form', [
    'model' => $model,
    'lista' => $lista,
]) ?>
