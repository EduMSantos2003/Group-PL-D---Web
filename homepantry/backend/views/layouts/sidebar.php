<?php
use hail812\adminlte\widgets\Menu;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Home Pantry</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">

        <!-- User Info (opcional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">User</a>
            </div>
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
                        'label' => 'User',
                        'icon' => 'users',
                        'url' => ['/user/index'],
                    ],
                    [
                        'label' => 'Produtos',
                        'icon' => 'box',
                        'url' => ['/produto/index'],
                    ],
                    [
                        'label' => 'Categorias',
                        'icon' => 'tags',
                        'url' => ['/categoria/index'],
                    ],
                    [
                        'label' => 'Listas',
                        'icon' => 'list',
                        'url' => ['/lista/index'],
                        'visible' => true, // podes ativar mais tarde
                    ],
                    [
                        'label' => 'Locais',
                        'icon' => 'map-marker-alt',
                        'url' => ['/local/index'],
                    ],
                    [
                        'label' => 'Logout',
                        'icon' => 'sign-out-alt',
                        'url' => ['/site/logout'],
                        'template' => '<a href="{url}" data-method="post">{icon} {label}</a>',
                        'visible' => !Yii::$app->user->isGuest,
                    ],
                ],
            ]) ?>
        </nav>
        <!-- /Menu -->

    </div>
    <!-- /Sidebar -->

</aside>
