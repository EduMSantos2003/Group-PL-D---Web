<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string|null $q                Termo de pesquisa introduzido pelo utilizador
 * @var array $produtos               Resultados da pesquisa em produtos
 * @var array $categorias             Resultados da pesquisa em categorias
 * @var array $listas                 Resultados da pesquisa em listas
 * @var array $locais                 Resultados da pesquisa em locais
 */

/* Define o título da página */
$this->title = 'Resultados da pesquisa';
?>

<div class="site-search">

    <!-- Título principal da página -->
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Mostra o termo pesquisado (com segurança contra XSS) -->
    <?php if ($q): ?>
        <p>
            Resultados para:
            <strong><?= Html::encode($q) ?></strong>
        </p>
    <?php else: ?>
        <p><em>Não foi introduzido nenhum termo de pesquisa.</em></p>
    <?php endif; ?>

    <hr>

    <!-- ===================== -->
    <!-- RESULTADOS: PRODUTOS -->
    <!-- ===================== -->
    <h3>Produtos</h3>

    <?php if (!empty($produtos)): ?>
        <ul>
            <?php foreach ($produtos as $produto): ?>
                <li>
                    <!-- Apresenta o nome do produto -->
                    <?= Html::encode($produto->nome) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><em>Não foram encontrados produtos.</em></p>
    <?php endif; ?>

    <hr>

    <!-- ======================= -->
    <!-- RESULTADOS: CATEGORIAS -->
    <!-- ======================= -->
    <h3>Categorias</h3>

    <?php if (!empty($categorias)): ?>
        <ul>
            <?php foreach ($categorias as $categoria): ?>
                <li>
                    <!-- Apresenta o nome da categoria -->
                    <?= Html::encode($categoria->nome) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><em>Não foram encontradas categorias.</em></p>
    <?php endif; ?>

    <hr>

    <!-- =================== -->
    <!-- RESULTADOS: LISTAS -->
    <!-- =================== -->
    <h3>Listas</h3>

    <?php if (!empty($listas)): ?>
        <ul>
            <?php foreach ($listas as $lista): ?>
                <li>
                    <!-- Apresenta o nome da lista -->
                    <?= Html::encode($lista->nome) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><em>Não foram encontradas listas.</em></p>
    <?php endif; ?>

    <hr>

    <!-- =================== -->
    <!-- RESULTADOS: LOCAIS -->
    <!-- =================== -->
    <h3>Locais</h3>

    <?php if (!empty($locais)): ?>
        <ul>
            <?php foreach ($locais as $local): ?>
                <li>
                    <!-- Apresenta o nome do local -->
                    <?= Html::encode($local->nome) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><em>Não foram encontrados locais.</em></p>
    <?php endif; ?>

</div>
