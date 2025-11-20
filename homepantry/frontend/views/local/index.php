<?php

use common\models\Local;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\LocalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Locais';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="local-index">

    <?php $this->beginBlock('hero');?>
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <h1 class="display-3 mb-3 animated slideInDown">Locais</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-body" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-dark active" aria-current="page">Locais</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    <?php $this -> endBlock() ?>

    <div>
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Categoria', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'idCasa',
            'nome',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Local $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
