<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use yii\bootstrap5\Html;

$this->title = 'HomePantry';

?>

<?php $this->beginBlock('hero'); ?>


<!-- Carousel Start -->
<div class="container-fluid px-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- SLIDE 1 -->
            <div class="carousel-item active">
                <img
                        src="<?= Url::to('@web/img/carousel-1.jpg') ?>"
                        class="d-block w-100 h-100 carousel-img"
                        alt="Despensa organizada"
                >
                <div class="carousel-overlay"></div>

                <div class="carousel-caption d-flex align-items-center h-100">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-6 col-md-8">
                                <h1 class="display-2 mb-4 animated slideInDown">
                                    Organiza a tua despensa em segundos
                                </h1>
                                <p class="mb-4 lead">
                                    Gere o stock de casa, controla validades e cria listas de compras num só sítio.
                                </p>

                                <?= Html::a(
                                    'Ver Stock',
                                    ['/stock-produto/index'],
                                    ['class' => 'btn btn-success rounded-pill py-sm-3 px-sm-5 me-3']
                                ) ?>

                                <?= Html::a(
                                    'Ver Listas de Compras',
                                    ['/lista/index'],
                                    ['class' => 'btn btn-outline-light rounded-pill py-sm-3 px-sm-5']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 2 -->
            <div class="carousel-item">
                <img
                        src="<?= Url::to('@web/img/carousel-2.jpg') ?>"
                        class="d-block w-100 h-100 carousel-img"
                        alt="Reduzir desperdício alimentar"
                >
                <div class="carousel-overlay"></div>

                <div class="carousel-caption d-flex align-items-center h-100">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-6 col-md-8">
                                <h1 class="display-2 mb-4 animated slideInDown">
                                    Menos desperdício, mais poupança
                                </h1>
                                <p class="mb-4 lead">
                                    Mantém o inventário atualizado e evita deixar produtos passar da validade.
                                </p>

                                <?php if (Yii::$app->user->isGuest): ?>
                                    <?= Html::a(
                                        'Criar Conta',
                                        ['/site/signup'],
                                        ['class' => 'btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3']
                                    ) ?>
                                    <?= Html::a(
                                        'Entrar',
                                        ['/site/login'],
                                        ['class' => 'btn btn-outline-light rounded-pill py-sm-3 px-sm-5']
                                    ) ?>
                                <?php else: ?>
                                    <?= Html::a(
                                        'Ir para a minha área',
                                        ['/site/index'],
                                        ['class' => 'btn btn-primary rounded-pill py-sm-3 px-sm-5']
                                    ) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controles -->
        <a class="carousel-control-prev"
           href="#header-carousel"
           role="button"
           data-bs-target="#header-carousel"
           data-bs-slide="prev"
           data-target="#header-carousel"
           data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </a>

        <a class="carousel-control-next"
           href="#header-carousel"
           role="button"
           data-bs-target="#header-carousel"
           data-bs-slide="next"
           data-target="#header-carousel"
           data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Seguinte</span>
        </a>

    </div>
</div>
<!-- Carousel End -->

<?php $this->endBlock(); ?>

<!--CSS extra para overlay -->
<style>
    .carousel-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1;
        pointer-events: none;
    }
    .carousel-caption {
        z-index: 2;
        text-align: left;
    }
    .carousel-img {
        object-fit: cover;
        max-height: 650px;
    }
    #header-carousel .carousel-control-prev,
    #header-carousel .carousel-control-next {
        z-index: 3;
    }
</style>

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="about-img position-relative overflow-hidden p-5 pe-0">
                    <img class="img-fluid w-100" src="<?= Url::to('@web/img/about.jpg') ?>" alt="Sobre o HomePantry">
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <h1 class="display-5 mb-4">HomePantry: a tua despensa digital</h1>
                <p class="mb-4">
                    O HomePantry ajuda-te a gerir o inventário da tua casa: produtos, quantidades,
                    datas de validade e listas de compras. Podes organizar por casa, local (despensa,
                    frigorífico, congelador, etc.) e manter tudo atualizado sem complicações.
                </p>
                <p><i class="fa fa-check text-primary me-3"></i>Gestão de produtos e categorias</p>
                <p><i class="fa fa-check text-primary me-3"></i>Controlo de quantidades e datas de validade</p>
                <p><i class="fa fa-check text-primary me-3"></i>Listas de compras ligadas ao stock</p>
                <p><i class="fa fa-check text-primary me-3"></i>Várias casas e locais por utilizador</p>

                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a(
                        'Começar a utilizar',
                        ['/site/signup'],
                        ['class' => 'btn btn-primary rounded-pill py-3 px-5 mt-3']
                    ) ?>
                <?php else: ?>
                    <?= Html::a(
                        'Ver o meu stock',
                        ['/stock-produto/index'],
                        ['class' => 'btn btn-primary rounded-pill py-3 px-5 mt-3']
                    ) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Features Start -->
<div class="container-fluid bg-light bg-icon my-5 py-6">
    <div class="container">
        <div class="section-header text-center mx-auto mb-5 wow fadeInUp"
             data-wow-delay="0.1s" style="max-width: 500px;">
            <h1 class="display-5 mb-3">O que podes fazer</h1>
            <p>Algumas das principais funcionalidades disponíveis no HomePantry.</p>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <img class="img-fluid mb-4" src="<?= Url::to('@web/img/icon-stock.png') ?>" alt="Gestão de stock">
                    <h4 class="mb-3">Gestão de Stock</h4>
                    <p>
                        Regista todos os produtos que tens em casa, organiza por locais e consulta rapidamente
                        o que está a acabar ou quase a expirar.
                    </p>
                    <?= Html::a(
                        'Ver stock',
                        ['/stock-produto/index'],
                        ['class' => 'btn btn-outline-primary border-2 py-2 px-4 rounded-pill']
                    ) ?>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <img class="img-fluid mb-4" src="<?= Url::to('@web/img/icon-listas.png') ?>" alt="Listas de compras">
                    <h4 class="mb-3">Listas de Compras</h4>
                    <p>
                        Cria listas de compras a partir do teu stock, marca os itens em falta e leva a lista
                        organizada sempre contigo.
                    </p>
                    <?= Html::a(
                        'Gerir listas',
                        ['/lista/index'],
                        ['class' => 'btn btn-outline-primary border-2 py-2 px-4 rounded-pill']
                    ) ?>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-white text-center h-100 p-4 p-xl-5">
                    <img class="img-fluid mb-4" src="<?= Url::to('@web/img/icon-casas.png') ?>" alt="Casas e locais">
                    <h4 class="mb-3">Casas e Locais</h4>
                    <p>
                        Define várias casas e locais de armazenamento (despensa, frigorífico, congelador) e
                        distribui os produtos por cada um deles.
                    </p>
                    <?= Html::a(
                            'Ver casas',
                            'http://localhost/Group-PL-D---Web/homepantry/backend/web/index.php?r=casa/index',
                            ['class' => 'btn btn-outline-primary border-2 py-2 px-4 rounded-pill']
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Features End -->


<!-- Quick Actions Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4 align-items-center mb-4">
            <div class="col-lg-6">
                <div class="section-header text-start wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-5 mb-3">Acessos rápidos</h1>
                    <p>
                        Entra diretamente nas secções que vais usar todos os dias:
                        stock, produtos, listas de compras e gestão de casas.
                    </p>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="product-item h-100">
                    <div class="position-relative bg-light overflow-hidden text-center p-4">
                        <i class="fa fa-box fa-3x mb-3 text-primary"></i>
                        <h5>Stock</h5>
                        <?= Html::a('Ir para Stock', ['/stock-produto/index'], ['class' => 'btn btn-sm btn-primary rounded-pill px-4']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="product-item h-100">
                    <div class="position-relative bg-light overflow-hidden text-center p-4">
                        <i class="fa fa-list-check fa-3x mb-3 text-primary"></i>
                        <h5>Listas</h5>
                        <?= Html::a('Ver Listas', ['/lista/index'], ['class' => 'btn btn-sm btn-primary rounded-pill px-4']) ?>
                    </div>
                </div>
            </div>


            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="product-item h-100">
                    <div class="position-relative bg-light overflow-hidden text-center p-4">
                        <i class="fa fa-tags fa-3x mb-3 text-primary"></i>
                        <h5>Produtos</h5>
                        <?= Html::a('Ver Produtos', ['/produto/index'], ['class' => 'btn btn-sm btn-primary rounded-pill px-4']) ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Quick Actions End -->


<!-- Call To Action -->
<div class="container-fluid bg-primary bg-icon mt-5 py-6">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-md-7 wow fadeIn" data-wow-delay="0.1s">
                <h1 class="display-5 text-white mb-3">Começa a organizar a tua despensa hoje</h1>
                <p class="text-white mb-0">
                    Cria uma conta gratuita, define a tua casa e locais de armazenamento e começa a registar o stock.
                </p>
            </div>
            <div class="col-md-5 text-md-end wow fadeIn" data-wow-delay="0.5s">
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('Criar Conta', ['/site/signup'], ['class' => 'btn btn-lg btn-secondary rounded-pill py-3 px-5 me-2 mb-2']) ?>
                    <?= Html::a('Já tenho conta', ['/site/login'], ['class' => 'btn btn-lg btn-outline-light rounded-pill py-3 px-5 mb-2']) ?>
                <?php else: ?>
                    <?= Html::a('Criar Nova Conta', ['/site/signup'], ['class' => 'btn btn-lg btn-secondary rounded-pill py-3 px-5']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Call To Action End -->
