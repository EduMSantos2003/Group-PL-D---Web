<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

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
    <link rel="stylesheet" type="text/css" href="../web/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../web/css/site.css">
    <link rel="stylesheet" type="text/css" href="../web/css/style.css">
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>

    <div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <small><i class="fa fa-map-marker-alt me-2"></i>123 Street MamaNaBoca, New York, USA</small>
                <small class="ms-4"><i class="fa fa-envelope me-2"></i>homepantry@example.com</small>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <a class="text-body ms-3" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
            <a href="main.php   " class="navbar-brand ms-4 ms-lg-0">
                <a href="/site/index" class="navbar-brand ms-4 ms-lg-0 d-flex align-items-center">
                    <!--<img src="/img/assets/HomePantryLogo.png" alt="Home Pantry" style="height:60px; width:auto; margin-right:10px;">-->
                    <h1 class="fw-bold text-primary m-0">HOME <span class="text-secondary">PANTRY</span></h1>
                </a>
                <!--<h1 class="fw-bold text-primary m-0">F<span class="text-secondary">oo</span>dy</h1>-->
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <ul class="navbar-nav ms-auto p-4 p-lg-0">
                        <li class="nav-item"><?= Html::a('Home', ['/site/index'], ['class' => 'nav-link fw-bold']) ?></li>
                        <li class="nav-item"><?= Html::a('Listas', ['/lista/index'], ['class' => 'nav-link fw-bold']) ?></li>
                        <li class="nav-item"><?= Html::a('Produtos', ['/produto/index'], ['class' => 'nav-link fw-bold']) ?></li>
                        <li class="nav-item"><?= Html::a('Categorias', ['/categoria/index'], ['class' => 'nav-link fw-bold']) ?></li>
                        <li class="nav-item"><?= Html::a('Local', ['/local/index'], ['class' => 'nav-link fw-bold']) ?></li>
                    </ul>

                    <?php
                    if (Yii::$app->user->isGuest) {
                        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                    }

                    echo Nav::widget([
                        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0 fw-bold'],
                        'items' => $menuItems,
                    ]);
                    if (Yii::$app->user->isGuest) {
                        echo Html::tag(
                            'div',
                            Html::a('Login', ['/site/login'], ['class' => 'nav-link fw-bold']),
                            ['class' => 'd-flex']
                        );
                    } else {
                        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                            . Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link logout text-decoration-none']
                            )
                            . Html::endForm();
                    }
                    ?>


                    <a href="about.html" class="nav-item nav-link">Utilizador</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                        <div class="dropdown-menu m-0">
                            <a href="blog.html" class="dropdown-item">Blog Grid</a>
                            <a href="feature.html" class="dropdown-item">Our Features</a>
                            <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                            <a href="404.html" class="dropdown-item">404 Page</a>
                        </div>
                    </div>
                    <a href="contact.html" class="nav-item nav-link">Contact Us</a>
                </div>
                <div class="d-none d-lg-flex ms-2">
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                        <small class="fa fa-search text-body"></small>
                    </a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                        <small class="fa fa-user text-body"></small>
                    </a>
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="">
                        <small class="fa fa-shopping-bag text-body"></small>
                    </a>
                </div>
            </div>
        </nav>
    </div>

</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <div class="footer-logo mb-4">
                    <?= Html::a(
                        Html::img('/img/HomePantryLogo.png', [
                            'alt' => 'Home Pantry',
                            'style' => 'height:60px; width:auto; margin-right:10px;'
                        ]) .
                        Html::tag('h1', 'HOME ' . Html::tag('span', 'PANTRY', ['class' => 'text-secondary']), [
                            'class' => 'fw-bold text-primary m-0'
                        ]),
                        ['/site/index'],
                        ['class' => 'navbar-brand ms-4 ms-lg-0 d-flex align-items-center']
                    ) ?>

                </div>



                <!--<h1 class="fw-bold text-primary mb-4">H<span class="text-secondary">oo</span>dy</h1>-->
                <p>Linha 131 do frontend Main</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4">Morada</h4>
                <p><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                <p><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                <p><i class="fa fa-envelope me-3"></i>homepantry@example.com</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4">Quick Links</h4>
                <a class="btn text" href="">About Us</a>
                <a class="btn text" href="">Contact Us</a>
                <a class="btn text" href="">Our Services</a>
                <a class="btn text" href="">Terms & Condition</a>
                <a class="btn text" href="">Support</a>
            </div>
            <div class="col-lg-3 col-md-6">
                <h4 class="mb-4">Newsletter</h4>
                <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                <div class="position-relative mx-auto" style="max-width: 400px;">
                    <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                    <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a href="#">Your Site Name</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../web/js/main.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
