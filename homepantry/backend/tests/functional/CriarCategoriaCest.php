<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Categoria;

final class CriarCategoriaCest
{
//    public function _before(FunctionalTester $I): void
//    {
//        // Code here will be executed before each test.
//    }

//    public function tryToTest(FunctionalTester $I): void
//    {
//        // Write your tests here. All `public` methods will be executed as tests.
//    }

    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    public function login(FunctionalTester $I)
    {
        // Abre a página de login do backend
        $I->amOnRoute('/site/login');

        // Preenche os campos (usa os names reais do formulário)
        $I->fillField('input[name="LoginForm[username]"]', 'erau');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');

        // Clica no botão de login (name="login-button" e texto LOGIN)
        $I->click('button[name="login-button"]');

        // Garante pelo menos que já não estás na página de login
        $I->dontSee('LOGIN', 'button[name="login-button"]');
    }

    /** CREATE */
    public function createCategoria(FunctionalTester $I): void
    {
        $this->login($I);

        $I->amOnRoute('categoria/create');

        $I->fillField('Categoria[nome]', 'Mercearia');
        $I->click('Save'); // ou o texto real do botão

        $I->see('Mercearia');
    }

    /** READ */
    public function testSaveAndReadCategoria(FunctionalTester $I)
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Laticínios',
            // exemplo se for obrigatório:
            // 'casa_id' => $casaId,
            // 'user_id' => 1,
        ]);

        $I->amOnRoute('categoria/view', ['id' => $categoriaId]);

        $I->see('Laticínios');
    }

    /** UPDATE */
    public function testUpdateAndReadCategoria(FunctionalTester $I)
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Bebidas',
            // 'casa_id' => $casaId,
            // 'user_id' => 1,
        ]);

        $I->amOnRoute('categoria/update', ['id' => $categoriaId]);

        $I->fillField('nome', 'Bebidas (Atualizado)');
        $I->click('Update');

        $I->see('Bebidas (Atualizado)');
    }

    /** DELETE */
    public function deleteCategoria(FunctionalTester $I)
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Delete',
            // 'casa_id' => $casaId,
            // 'user_id' => 1,
        ]);

        $I->amOnRoute('categoria/view', ['id' => $categoriaId]);

        // se for um botão gerado pelo Gii:
        $I->click('Delete'); // ou 'Apagar', conforme o texto real

        // garante que o registo já não existe
        $I->dontSeeRecord(Categoria::class, ['id' => $categoriaId]);
    }

}


