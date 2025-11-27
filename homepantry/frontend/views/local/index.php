<?php

use common\models\Local;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;


/** @var yii\web\View $this */
/** @var common\models\LocalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Locals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="local-index">

    <?php $this->beginBlock('hero');?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">

            <h1 class="display-3 mb-3 animated slideInDown"><?= Html::encode($this->title) ?></h1>

            <nav aria-label="breadcrumb" class="animated slideInDown">
                   <?= Breadcrumbs::widget([
                       'options' => ['class' => 'breadcrumb mb-0'],
                       'links' => $this->params['breadcrumbs'],
                   ]) ?>
            </nav>

        </div>
    </div>
    <!-- Page Header End -->
    <?php $this -> endBlock() ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Local', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'casa_id',
            'nome',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Local $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
