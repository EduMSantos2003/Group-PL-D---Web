<?php
use hail812\adminlte\widgets\Menu;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Logo -->
    <a href="<?= Url::to(['/site/index']) ?>" class="brand-link d-flex justify-content-center">
        <span class="brand-text font-weight-light">Home Pantry - Backend</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Info (opcional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php if (Yii::$app->user->isGuest): ?>
                <div class="image d-flex align-items-center">
                    <a href="<?= Url::to(['/site/login']) ?>">
                        <i class="fas fa-user-circle text-white" style="font-size: 2rem;"></i>
                    </a>
                </div>
                <div class="info d-flex align-items-center">
                    <a href="<?= Url::to(['/site/login']) ?>" class="d-block text-white ms-2">
                        Login
                    </a>
                </div>
            <?php else: ?>
                <div class="image d-flex align-items-center">
                    <i class="fas fa-user-circle text-white" style="font-size: 2rem;"></i>
                </div>
                <div class="info d-flex align-items-center">
            <span class="d-block text-white ms-2">
                <?= Html::encode(Yii::$app->user->identity->username) ?>
            </span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <?= Menu::widget([
                'items' => [
                    [
                        'label' => 'Dashboard',
                        'icon' => 'tachometer-alt',
                        'url' => ['/site/index'],
                    ],
                    [
                        'label' => 'Utilizadores',
                        'icon' => 'users',
                        'url' => ['/user/index'],
                    ],
                    [
                        'label' => 'Casas',
                        'icon' => 'home',
                        'url' => ['/casa/index'],
                    ],
                    [
                        'label' => 'Casas-Utilizadores',
                        'icon' => 'user-friends',
                        'url' => ['/casa-utilizador/index'],
                    ],
                    [
                        'label' => 'Categorias',
                        'icon' => 'tags',
                        'url' => ['/categoria/index'],
                    ],
                    [
                        'label' => 'Locais',
                        'icon' => 'map-marker-alt',
                        'url' => ['/local/index'],
                    ],
                        [
                                'label' => 'Histórico Preços',
                                'icon' => 'chart-line',
                                'url' => ['/historico-preco/index'],
                        ],
                ],
            ]) ?>
        </nav>
        <!-- /Menu -->

    </div>
    <!-- /Sidebar -->

</aside>
