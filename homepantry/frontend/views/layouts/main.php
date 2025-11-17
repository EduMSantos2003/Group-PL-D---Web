<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <!-- BRAND / LOGO -->
        <?= Html::a(
            '<div class="d-flex align-items-center">
                <img src="' . Url::to('@web/img/HomePantryLogo.png') . '" alt="Home Pantry" style="height:60px; width:auto; margin-right:10px;">
                <h1 class="fw-bold text-primary m-0">HOME <span class="text-secondary">PANTRY</span></h1>
            </div>',
            ['/site/index'],
            ['class' => 'navbar-brand ms-4 ms-lg-0']
        ) ?>

        <!-- TOGGLER MOBILE -->
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- MENU -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <?= Html::a('Listas', ['/lista/index'], ['class' => 'nav-item nav-link fw-bold']) ?>
                <?= Html::a('Produtos', ['/produto/index'], ['class' => 'nav-item nav-link fw-bold']) ?>
                <?= Html::a('Categorias', ['/categoria/index'], ['class' => 'nav-item nav-link fw-bold']) ?>
                <?= Html::a('Local', ['/local/index'], ['class' => 'nav-item nav-link fw-bold']) ?>

                <?php if (!Yii::$app->user->isGuest): ?>
                    <!-- Dropdown com username APENAS quando está autenticado -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                            <?= Html::encode(Yii::$app->user->identity->username) ?>
                        </a>
                        <div class="dropdown-menu m-0">
                            <?= Html::a('Perfil', ['#'], ['class' => 'dropdown-item']) ?>
                            <?= Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton('Logout', ['class' => 'dropdown-item text-start'])
                            . Html::endForm(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ICONES LADO DIREITO -->
            <div class="d-none d-lg-flex ms-2">
                <!-- Search -->
                <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
                    <small class="fa fa-search text-body"></small>
                </a>

                <!-- User icon = LOGIN quando guest / PERFIL (ou outra rota) quando autenticado -->
                <?php if (Yii::$app->user->isGuest): ?>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="<?= Url::to(['/site/login']) ?>">
                        <small class="fa fa-user text-body"></small>
                    </a>
                <?php else: ?>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
                        <small class="fa fa-user text-body"></small>
                    </a>
                <?php endif; ?>

                <!-- Carrinho / saco -->
                <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
                    <small class="fa fa-shopping-bag text-body"></small>
                </a>
            </div>
        </div>
    </nav>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!-- FOOTER -->
<div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <!-- Coluna logo + social -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-logo mb-4">
                    <?= Html::a(
                        '<div class="d-flex align-items-center">
                            ' . Html::img(Url::to('@web/img/HomePantryLogo.png'), [
                            'alt' => 'Home Pantry',
                            'style' => 'height:60px; width:auto; margin-right:10px;'
                        ]) . '
                            <h1 class="fw-bold text-primary m-0">HOME <span class="text-secondary">PANTRY</span></h1>
                        </div>',
                        ['/site/index'],
                        ['class' => 'navbar-brand ms-4 ms-lg-0 d-flex align-items-center']
                    ) ?>
                </div>

                <p>Linha 131 do frontend Main</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href="#"><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-0" href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Morada -->
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 text-white">Morada</h4>
                <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                <p><i class="fa fa-envelope me-3"></i>homepantry@example.com</p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 text-white">Quick Links</h4>
                <a class="btn btn-link text-start text-white-50" href="#">About Us</a>
                <a class="btn btn-link text-start text-white-50" href="#">Contact Us</a>
                <a class="btn btn-link text-start text-white-50" href="#">Our Services</a>
                <a class="btn btn-link text-start text-white-50" href="#">Terms &amp; Condition</a>
                <a class="btn btn-link text-start text-white-50" href="#">Support</a>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4 text-white">Newsletter</h4>
                <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">
                        SignUp
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS extra do template -->
<?= Html::jsFile('@web/js/main.js') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
