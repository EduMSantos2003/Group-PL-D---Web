<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;

//css
$this->registerCssFile('@web/css/produtos.css', [
    'depends' => [\yii\web\YiiAsset::class]
]);
//css


?>

<?php $this->beginBlock('hero');?>

<!-- Page Header Start -->
<div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="display-3 mb-3 animated slideInDown">Produtos</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-body" href="#">Pages</a></li>
                <li class="breadcrumb-item text-dark active" aria-current="page">Produtos</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
<?php $this -> endBlock() ?>

<div class="row g-0 gx-5 align-items-end">
    <div class="col-lg-6">
        <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <?= Html::tag('h1', 'Stock Produtos', ['class' => 'display-5 mb-3'])?>
            <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <!--<div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
        <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
            <li class="nav-item me-2">
                <a class="btn btn-outline-primary border-2 active" data-bs-toggle="pill" href="#tab-1">Vegetais</a>
            </li>
            <li class="nav-item me-2">
                <a class="btn btn-outline-primary border-2" data-bs-toggle="pill" href="#tab-2">Frutas </a>
            </li>
            <li class="nav-item me-0">
                <a class="btn btn-outline-primary border-2" data-bs-toggle="pill" href="#tab-3">Congelados</a>
            </li>
        </ul>
    </div>-->

    <div>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // COLUNA DA IMAGEM
                [
                    'label' => 'Imagem',
                    'format' => 'html',
                    'value' => function ($model) {

                        // cria o nome da imagem a partir do nome do produto
                        $nome = strtolower(trim($model->nome));
                        $nome = str_replace(' ', '-', $nome);

                        // caminho da imagem na pasta do frontend
                        $ficheiro = "/images/produtos/{$nome}.png";

                        // caminho real no servidor
                        $caminhoServidor = Yii::getAlias("@webroot{$ficheiro}");

                        // se existir, usa essa imagem
                        if (file_exists($caminhoServidor)) {
                            return Html::img($ficheiro, [
                                'class' => 'img-produto'
                            ]);
                        }

                        // senão, usa a imagem padrão
                        return Html::img('/images/produtos/default.png', [
                            'class' => 'img-produto'
                        ]);
                    }
                ],

                // COLUNA COM NOME DA CATEGORIA
                [
                    'attribute' => 'idCategoria',
                    'label' => 'Categoria',
                    'value' => function ($model) {
                        return $model->categoria ? $model->categoria->nome : '—';
                    }
                ],

                'nome',
                'descricao',
                'unidade',

                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Produto $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>

    </div>
</div>

