<?php

declare(strict_types=1);

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Categoria;
use common\models\Produto;
use common\models\Casa;
use common\models\CasaUtilizador;
use common\models\Local;
use common\models\StockProduto;

final class StockProdutoCest
{
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    private function loginComPermissao(FunctionalTester $I): int
    {
        $I->amOnRoute('/site/login');
        $I->fillField('#loginform-username', 'erau');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('button[name="login-button"]');
        $I->dontSee('LOGIN');

        return 1; // user id
    }

    public function createStockProduto(FunctionalTester $I): void
    {
        $userId = $this->loginComPermissao($I);

        // Categoria
        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Categoria Stock',
        ]);

        // Produto
        $produtoId = $I->haveRecord(Produto::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Arroz Stock',
            'descricao' => 'Produto para stock',
            'preco' => 1.50,
            'validade' => '2026-12-31',
            'imagem' => 'dummy.jpg',
        ]);

        // Casa
        $casaId = $I->haveRecord(Casa::class, [
            'nome' => 'Casa Teste',
            'utilizadorPrincipal_id' => $userId,
        ]);

        // CasaUtilizador
        $I->haveRecord(CasaUtilizador::class, [
            'casa_id' => $casaId,
            'utilizador_id' => $userId,
        ]);

        // Local
        $localId = $I->haveRecord(Local::class, [
            'nome' => 'Despensa',
            'casa_id' => $casaId,
        ]);

        // abrir form
        $I->amOnRoute('/stock-produto/create');

        $I->selectOption('#stockproduto-produto_id', (string)$produtoId);
        $I->selectOption('#stockproduto-local_id', (string)$localId);
        $I->fillField('#stockproduto-quantidade', '3');

        $I->click('Save');

        // ASSERT DB
        $I->seeRecord(StockProduto::class, [
            'produto_id' => $produtoId,
            'local_id' => $localId,
            'quantidade' => 3,
        ]);
    }
}
