<?php

use common\models\ListaProduto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var $lista common\models\Lista */
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos da lista: ' . $lista->nome;
$this->params['breadcrumbs'][] = ['label' => 'Listas', 'url' => ['lista/index']];
$this->params['breadcrumbs'][] = $lista->nome;
?>

<div class="lista-produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
            'Adicionar produto',
            ['create', 'lista_id' => $lista->id],
            ['class' => 'btn btn-success']
        ) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'produto.nome',
                'label' => 'Produto',
            ],
            'quantidade',
            'precoUnitario:currency',
            'subTotal:currency',

            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model) use ($lista) {
                    return Url::toRoute([
                        'lista-produto/' . $action,
                        'id' => $model->id,
                        'lista_id' => $lista->id,
                    ]);
                },
            ],
        ],
    ]); ?>

    <?php
    $listaId = Yii::$app->request->get('lista_id');
    ?>

    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

    <script>
        const listaId = <?= (int)$listaId ?>;

        // liga ao broker por WebSocket
        const client = mqtt.connect('ws://localhost:9001');

        client.on('connect', () => {
            console.log('Ligado ao broker MQTT');
            client.subscribe('lista/' + listaId);
        });

        client.on('message', (topic, message) => {
            const data = JSON.parse(message.toString());

            // mensagem visível ao utilizador
            const alerta = document.createElement('div');
            alerta.className = 'alert alert-warning';
            alerta.innerHTML =
                '⚠️ A lista foi alterada (' + data.acao + ')<br>' +
                'Produto ID: ' + (data.produto_id ?? '-') +
                ' | Quantidade: ' + (data.quantidade ?? '-');

            document.querySelector('.container').prepend(alerta);

            // opcional: remover após 5s
            setTimeout(() => alerta.remove(), 5000);
        });

    </script>
    <?= \yii\helpers\Html::a(
        'Apagar todos os produtos',
        ['lista-produto/clear', 'lista_id' => $lista->id],
        [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer apagar TODOS os produtos desta lista?',
                'method' => 'post',
            ],
        ]
    ) ?>



</div>
