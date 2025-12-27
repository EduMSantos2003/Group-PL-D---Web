<?php

use common\models\Local;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;



/** @var yii\web\View $this */
/** @var common\models\LocalSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Locais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="local-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Criar um novo Local', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'mb-3'],
    ]); ?>

    <div class="input-group" style="max-width: 420px;">
        <span class="input-group-text">🔍</span>
        <?= Html::activeTextInput($searchModel, 'nome', [
            'class' => 'form-control',
            'placeholder' => 'Pesquisar Local',
        ]) ?>
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a('Limpar', ['index'], ['class' => 'btn btn-outline-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'label' => 'Casa',
                'value' => 'casa.nome',
            ],
            //'casa_id',
            'nome',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Local $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]);
    ?>


</div>
