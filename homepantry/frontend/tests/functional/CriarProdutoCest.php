<?php

declare(strict_types=1);

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

final class CriarProdutoCest
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

    private function login(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/login');

        $I->fillField('#loginform-username', 'erau');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('button[name="login-button"]');

        $I->dontSee('LOGIN');
    }

    public function createProduto(FunctionalTester $I): void
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'Categoria Teste',
        ]);

        $I->amOnRoute('/produto/create');

        $I->selectOption('select[name="categoria_id"]', (string)$categoriaId);
        $I->fillField('input[name="nome"]', 'Arroz Agulha');
        $I->fillField('input[name="descricao"]', 'Arroz para testes funcionais');
        $I->fillField('input[name="preco"]', '1.99');
        $I->fillField('input[name="validade"]', '20/01/2026');

        // ⚠NÃO testar upload em funcional
        $I->click('Guardar');

        // verifica diretamente na BD
        $I->seeRecord(\common\models\Produto::class, [
            'nome' => 'Arroz Agulha',
        ]);
    }

    public function updateProduto(FunctionalTester $I): void
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'Categoria Update',
        ]);

        $produtoId = $I->haveRecord(\common\models\Produto::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Leite Meio-Gordo',
            'descricao' => 'Produto para editar',
            'preco' => 0.89,
            'validade' => '2026-02-10',
            'imagem' => 'dummy.jpg',
        ]);

        $I->amOnRoute('/produto/update', ['id' => $produtoId]);

        $I->fillField('input[name="nome"]', 'Leite Meio-Gordo (Atualizado)');
        $I->click('Guardar');

        $I->seeRecord(\common\models\Produto::class, [
            'nome' => 'Leite Meio-Gordo (Atualizado)',
        ]);
    }
}
