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

                <?php if (!Yii::$app->user->isGuest): ?>

                    <?= Html::a('Stock', ['/stock-produto/index'], ['class' => 'nav-item nav-link fw-bold']) ?>
                    <?= Html::a('Listas', ['/lista/index'], ['class' => 'nav-item nav-link fw-bold']) ?>
                    <?= Html::a('Produtos', ['/produto/index'], ['class' => 'nav-item nav-link fw-bold']) ?>

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
            <div class="d-none d-lg-flex ms-2 align-items-center">

                <?php if (!Yii::$app->user->isGuest): ?>
                    <!-- LUPA (toggle) -->
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="#" id="searchToggle" aria-label="Abrir pesquisa">
                        <small class="fa fa-search text-body"></small>
                    </a>
                <!-- FORM PESQUISA (escondido) -->
                    <form
                            id="searchForm"
                            class="d-none align-items-center ms-2"
                            action="<?= Url::to(['/search/index']) ?>"
                            method="get"
                    >
                        <input
                            type="search"
                            name="q"
                            class="form-control form-control-sm"
                            placeholder="Pesquisar..."
                            aria-label="Pesquisar"
                            style="width: 180px;"
                            value="<?= Html::encode(Yii::$app->request->get('q', '')) ?>"
                        >
                    </form>
                <?php endif; ?>

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

                <?php if (!Yii::$app->user->isGuest): ?>
                    <!-- Carrinho / saco -->
                    <a class="btn-sm-square bg-white rounded-circle ms-3" href="#">
                        <small class="fa fa-shopping-bag text-body"></small>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php
    //Estamos a definir a página (site/index) como home, para depois definir o título + breadcrumbs em todas as páginas menos no site/index
    // Se não estivermos na home (site/index), mostramos o Page Header com título + breadcrumbs
    $isHome = Yii::$app->controller->id === 'site'
        && Yii::$app->controller->action->id === 'index';
    ?>

    <?php if (!$isHome): ?>
        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <h1 class="display-3 mb-3 animated slideInDown">
                    <?= Html::encode($this->title) ?>
                </h1>

                <nav aria-label="breadcrumb" class="animated slideInDown">
                    <?= Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'] ?? [],
                    ]); ?>
                </nav>
            </div>
        </div>
        <!-- Page Header End -->
    <?php endif; ?>

</header>

<?php if (isset($this->blocks['hero'])): ?>
    <?= $this->blocks['hero'] ?>
<?php endif; ?>

<main role="main" class="flex-shrink-0">
    <div class="container">

        <?php
        // Breadcrumbs removidos do layout – agora estão no HERO de cada página
        /*
        echo Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
        ]);
        */
        ?>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!-- FOOTER -->
<div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">

            <!-- LOGO + TEXTO -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <?= Html::img(
                        Url::to('@web/img/HomePantryLogo.png'),
                        ['alt' => 'HomePantry', 'style' => 'height:60px; width:auto; margin-right:10px;']
                    ) ?>
                    <h3 class="fw-bold text-primary m-0">
                        HOME <span class="text-secondary">PANTRY</span>
                    </h3>
                </div>

                <p class="text-black-50 mb-3">
                    Gere o inventário da tua casa, controla validades e reduz o desperdício alimentar
                    com a ajuda do HomePantry.
                </p>

                <div class="d-flex pt-2">
                    <a class="btn btn-square btn-outline-light rounded-circle me-2" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-2" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="btn btn-square btn-outline-light rounded-circle me-2" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="btn btn-square btn-outline-light rounded-circle" href="#">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- CONTACTOS -->
            <div class="col-lg-4 col-md-6">
                <h4 class="mb-4 text-black">Contactos</h4>
                <p class="text-black-50 mb-2">
                    <i class="fa fa-envelope me-2 text-primary"></i> suporte@homepantry.app
                </p>
                <p class="text-black-50 mb-2">
                    <i class="fa fa-phone-alt me-2 text-primary"></i> +351 912 345 678
                </p>
                <p class="text-black-50 mb-2">
                    <i class="fa fa-map-marker-alt me-2 text-primary"></i> Lisboa, Portugal
                </p>
                <p class="text-black-50 small mt-3">
                    Suporte disponível em horário laboral.
                </p>
            </div>

            <!-- LINKS ÚTEIS -->
            <div class="col-lg-4 col-md-6">
                <h4 class="mb-4 text-black">Links úteis</h4>

                <a class="btn btn-link text-start text-black-50 d-block" href="<?= Url::to(['/lista/index']) ?>">
                    <i class="fa fa-arrow-right me-2 text-primary"></i> As minhas listas
                </a>
                <a class="btn btn-link text-start text-black-50 d-block" href="<?= Url::to(['/produto/index']) ?>">
                    <i class="fa fa-arrow-right me-2 text-primary"></i> Produtos
                </a>
                <a class="btn btn-link text-start text-black-50 d-block" href="<?= Url::to(['/local/index']) ?>">
                    <i class="fa fa-arrow-right me-2 text-primary"></i> Locais
                </a>
                <a class="btn btn-link text-start text-black-50 d-block" href="#">
                    <i class="fa fa-arrow-right me-2 text-primary"></i> Ajuda
                </a>
            </div>
        </div>
    </div>

    <!-- COPYRIGHT -->
    <div class="container-fluid copyright mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0 text-black-50">
                    © <?= date('Y') ?> HomePantry. Todos os direitos reservados.
                </div>
                <div class="col-md-6 text-center text-md-end text-black-50">
                    Template base por HTML Codex · Adaptado para HomePantry
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FOOTER END -->

<?php
$this->registerJs(<<<JS
(function () {
  const toggle = document.getElementById('searchToggle');
  const form = document.getElementById('searchForm');
  if (!form) return;

  const input = form.querySelector('input[name="q"]');

  // Abrir/focar com a lupa
  if (toggle) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();

      const isHidden = form.classList.contains('d-none');

      if (isHidden) {
        form.classList.remove('d-none');
        if (input) { input.focus(); input.select(); }
      } else {
        // Se já está aberto, clicar na lupa faz pesquisa
        if (input && input.value.trim() !== '') form.submit();
        else if (input) input.focus();
      }
    });
  }

  // Garantir que Enter submete (em alguns templates isto pode ser bloqueado)
  if (input) {
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        if (input.value.trim() !== '') form.submit();
      }
    });
  }

  // Bloquear submit vazio
  form.addEventListener('submit', function (e) {
    if (!input || input.value.trim() === '') {
      e.preventDefault();
      if (input) input.focus();
    }
  });
})();
JS);
?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
