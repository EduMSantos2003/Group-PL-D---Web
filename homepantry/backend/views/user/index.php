<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Utilizadores";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'username',
            'email:email',
            [
                'attribute' => 'status',
                'label' => 'Estado',
                'value' => function($model) {
                    return $model->statusName;
                },
                'filter' => [
                    10 => 'Ativo',
                    9  => 'Inativo',
                    0  => 'Eliminado',
                ],
            ],


            [
                'label' => 'Role',
                'value' => function ($model) {
                    return $model->roleName;
                },
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>



</div>
