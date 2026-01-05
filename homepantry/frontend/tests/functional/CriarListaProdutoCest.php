<?php

declare(strict_types=1);


namespace frontend\tests\Functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;
use common\models\Categoria;
use common\models\Produto;
use common\models\Lista;
use common\models\ListaProduto;
use Yii;

final class CriarListaProdutoCest
{
    /*public function _before(FunctionalTester $I): void
    {
        // Code here will be executed before each test.
    }*/

    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    private function login(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/login');

        $I->fillField('#loginform-username', 'erau');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('button[name="login-button"]');

        $I->dontSee('LOGIN');
    }
    public function createListaProduto(FunctionalTester $I): void
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Categoria ListaProduto',
        ]);

        $listaId = $I->haveRecord(Lista::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Lista de Teste',
            'tipo' => 'Compras',
        ]);

        $produtoId = $I->haveRecord(Produto::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Massa Esparguete',
            'descricao' => 'Produto para lista-produto',
            'preco' => 0.99,
            'validade' => '2026-02-10',
            'imagem' => 'dummy.jpg',
        ]);

        // ✅ actionCreate($lista_id) exige lista_id
        $I->amOnRoute('/lista-produto/create', ['lista_id' => $listaId]);

        $I->selectOption('select[name="ListaProduto[produto_id]"]', (string)$produtoId);
        $I->fillField('input[name="ListaProduto[quantidade]"]', '2');
        $I->click('Adicionar');

        // ✅ Em testes estás em /index-test.php?r=...
        $I->seeInCurrentUrl('r=lista-produto%2Findex');
        $I->seeInCurrentUrl('lista_id=' . $listaId);

        $I->seeRecord(ListaProduto::class, [
            'lista_id' => $listaId,
            'produto_id' => $produtoId,
            'quantidade' => 2,
        ]);
    }

    public function updateListaProduto(FunctionalTester $I): void
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Categoria ListaProduto Update',
        ]);

        $listaId = $I->haveRecord(Lista::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Lista Update',
            'tipo' => 'Compras',
        ]);

        $produtoId = $I->haveRecord(Produto::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Atum em lata',
            'descricao' => 'Produto update',
            'preco' => 1.49,
            'validade' => '2026-03-01',
            'imagem' => 'dummy.jpg',
        ]);

        $listaProdutoId = $I->haveRecord(ListaProduto::class, [
            'lista_id' => $listaId,
            'produto_id' => $produtoId,
            'quantidade' => 1,
        ]);

        // ✅ actionUpdate($id, $lista_id) exige os dois
        $I->amOnRoute('/lista-produto/update', [
            'id' => $listaProdutoId,
            'lista_id' => $listaId,
        ]);

        $I->fillField('input[name="ListaProduto[quantidade]"]', '4');
        $I->click('Adicionar');

        // ✅ Verifica redirect real
        $I->seeInCurrentUrl('r=lista-produto%2Findex');
        $I->seeInCurrentUrl('lista_id=' . $listaId);

        $I->seeRecord(ListaProduto::class, [
            'id' => $listaProdutoId,
            'quantidade' => 4,
        ]);
    }


    /*public function tryToTest(FunctionalTester $I): void
    {
        // Write your tests here. All `public` methods will be executed as tests.
    }*/
}
