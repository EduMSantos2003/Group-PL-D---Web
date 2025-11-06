<?php

use common\models\ListaProduto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\ListaProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lista-produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Lista Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->id), ['view', 'id' => $model->id]);
        },
    ]) ?>


</div>
