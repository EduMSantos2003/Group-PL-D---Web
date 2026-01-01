<?php
/** @var array $stats */
/** @var \common\models\Produtos[] $produtosExpirar */
/** @var \common\models\Listas[] $listasRecentes */

use yii\helpers\Html;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">

    <!-- Linha de InfoBoxes principais -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Utilizadores',
                'number' => $stats['utilizadores'],
                'icon' => 'fas fa-users',
                'theme' => 'gradient-info',
            ]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Casas',
                'number' => $stats['casas'],
                'icon' => 'fas fa-home',
                'theme' => 'gradient-success',
            ]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Produtos',
                'number' => $stats['produtos'],
                'icon' => 'fas fa-box',
                'theme' => 'gradient-warning',
            ]) ?>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Listas de compras',
                'number' => $stats['listas'],
                'icon' => 'fas fa-list',
                'theme' => 'gradient-danger',
            ]) ?>
        </div>
    </div>

    <!-- Segunda linha: Locais + qualquer coisa no futuro -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $stats['locais'],
                'text' => 'Locais de Armazenamento',
                'icon' => 'fas fa-map-marker-alt',
                'theme' => 'primary',
            ]) ?>
        </div>
        <!-- espaço para futuras métricas -->
    </div>

    <div class="row">

        <!-- Coluna: Produtos a expirar -->
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Produtos a expirar em breve</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Validade</th>
                            <th>Local</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($produtosExpirar)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Não há produtos perto do fim de validade 🎉
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($produtosExpirar as $stock): ?>
                                <tr>
                                    <td><?= Html::encode($stock->produto->nome ?? '—') ?></td>
                                    <td><?= Html::encode($stock->quantidade) ?></td>
                                    <td><?= Html::encode($stock->validade) ?></td>
                                    <td><?= Html::encode($stock->local->nome ?? '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coluna: Listas recentes -->
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listas de compras recentes</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Utilizador</th>
                            <th>Total estimado</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($listasRecentes)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Ainda não existem listas criadas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listasRecentes as $lista): ?>
                                <tr>
                                    <td><?= Html::encode($lista->nome) ?></td>
                                    <td><?= Html::encode($lista->utilizador->nome ?? '—') ?></td>
                                    <td><?= Html::encode($lista->totalEstimado) ?> €</td>
                                    <td><?= Html::encode($lista->dataCriacao) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>
