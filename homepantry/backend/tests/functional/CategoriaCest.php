<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

final class CategoriaCest
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
    public function createCategoria(FunctionalTester $I)
    {
        $this->login($I);

        $I->amOnRoute('/categoria/create');

        // Como Categoria::formName() retorna '', o input chama-se "nome"
        $I->fillField('nome', 'Mercearia');
        $I->click('Save'); // troca para 'Guardar' se for esse o texto

        $I->see('Mercearia');
    }

    /** READ (ver a página view de uma categoria existente) */
    public function testSaveAndReadCategoria(FunctionalTester $I)
    {
        $this->login($I);

        // cria categoria diretamente na BD de testes
        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'Laticínios',
        ]);

        // abre a view
        $I->amOnRoute('/categoria/view', ['id' => $categoriaId]);

        // confirma que o nome aparece
        $I->see('Laticínios');
    }

    /** UPDATE */
    public function testUpdateAndReadCategoria(FunctionalTester $I)
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'Bebidas',
        ]);

        $I->amOnRoute('/categoria/update', ['id' => $categoriaId]);

        $I->fillField('nome', 'Bebidas (Atualizado)');
        $I->click('Guardar');

        $I->see('Bebidas (Atualizado)');
    }

    /** DELETE */
    public function deleteCategoria(FunctionalTester $I): void
    {
        $this->login($I);

        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'A Apagar',
        ]);

        /**
         * O delete normalmente exige POST (VerbFilter).
         * Esta é a forma mais estável: chamar diretamente a rota com POST.
         */
        $I->sendPostRequest('/categoria/delete?id=' . $categoriaId);

        // depois do delete, muitos CRUDs redirecionam para o index
        $I->amOnRoute('/categoria/index');

        // confirmar que já não aparece no index
        $I->dontSee('A Apagar');
    }
}


