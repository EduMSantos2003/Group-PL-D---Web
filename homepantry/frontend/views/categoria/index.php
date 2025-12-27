<?php

use common\models\Categoria;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\CategoriaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categorias';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/imagens.css');
$this->registerCssFile('@web/css/butoes.css');
?>
<div class="categoria-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold"><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Create Categoria', ['create'], ['class' => 'btn-create']) ?>
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
            'placeholder' => 'Pesquisar Categoria',
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
            'nome',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Categoria $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
