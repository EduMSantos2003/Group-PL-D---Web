<?php

declare(strict_types=1);

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

final class CriarListaCest
{
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    private function login(FunctionalTester $I): void
    {
        $I->amOnRoute('/site/login');

        // Dados de login do fixture (erau / password_0 no advanced template)
        $I->fillField('#loginform-username', 'erau');
        $I->fillField('#loginform-password', 'password_0');
        $I->click('button[name="login-button"]');

        $I->dontSee('LOGIN');
    }

    public function createLista(FunctionalTester $I): void
    {
        $this->login($I);

        $I->amOnRoute('/lista/create');

        // Campos gerados pelo ActiveForm: id="lista-nome" e id="lista-tipo"
        $I->fillField('#lista-nome', 'Lista de Compras Teste');
        $I->fillField('#lista-tipo', 'Mensal');

        // Botão padrão do Gii: Html::submitButton('Save', ['class' => 'btn btn-success'])
        $I->click('Save');              // ou: $I->click('button.btn-success');

        $I->seeRecord(\common\models\Lista::class, [
            'nome' => 'Lista de Compras Teste',
            'tipo' => 'Mensal',
        ]);
    }

    public function updateLista(FunctionalTester $I): void
    {
        $this->login($I);

        // Registo inicial na BD para editar
        $listaId = $I->haveRecord(\common\models\Lista::class, [
            'nome' => 'Lista para editar',
            'tipo' => 'Semanal',
        ]);

        $I->amOnRoute('/lista/update', ['id' => $listaId]);

        $I->fillField('#lista-nome', 'Lista para editar (Atualizada)');
        $I->fillField('#lista-tipo', 'Mensal');

        $I->click('Save');              // ou: $I->click('button.btn-success');

        $I->seeRecord(\common\models\Lista::class, [
            'id'   => $listaId,
            'nome' => 'Lista para editar (Atualizada)',
            'tipo' => 'Mensal',
        ]);
    }
}
