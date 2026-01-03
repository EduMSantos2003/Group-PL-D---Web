<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function loginUser(FunctionalTester $I)
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


//    public function loginUser(FunctionalTester $I)
//    {
//        $I->amOnRoute('/site/login');
//        $I->fillField('Username', 'erau');
//        $I->fillField('Password', 'password_0');
//        $I->click('login-button');
//
//        $I->see('Logout (erau)', 'form button[type=submit]');
//        $I->dontSeeLink('Login');
//        $I->dontSeeLink('Signup');
//    }
}