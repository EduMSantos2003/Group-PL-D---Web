<?php

use yii\helpers\Html;
use common\models\User;
use common\services\NotificationService;
use backend\controllers\SearchController;
$notifications = NotificationService::getRecent(6);

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3" method="get" action="">
        <input type="hidden" name="r" value="search/index">

        <div class="input-group input-group-sm">
            <input
                    name="q"
                    class="form-control form-control-navbar"
                    type="search"
                    placeholder="Pesquisar menus..."
                    aria-label="Search"
            >
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <?php if (count($notifications)): ?>
                    <span class="badge badge-warning navbar-badge">
                <?= count($notifications) ?>
            </span>
                <?php endif; ?>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header">
            <?= count($notifications) ?> novidades recentes
        </span>

                <div class="dropdown-divider"></div>

                <?php foreach ($notifications as $n): ?>
                    <?= \yii\helpers\Html::a(
                            '<i class="fas fa-' . $n['icon'] . ' mr-2"></i>' .
                            \yii\helpers\Html::encode($n['label']) .
                            '<span class="float-right text-muted text-sm">' .
                            Yii::$app->formatter->asRelativeTime($n['date']) .
                            '</span>',
                            $n['url'],
                            ['class' => 'dropdown-item']
                    ) ?>
                <?php endforeach; ?>

                <div class="dropdown-divider"></div>

                <span class="dropdown-item dropdown-footer text-muted">
            Atividade recente do sistema
        </span>
            </div>
        </li>

        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->