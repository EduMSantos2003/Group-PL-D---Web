<?php

declare(strict_types=1);

namespace backend\tests\Functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\Categoria;
use common\models\User;
use Yii;

final class CriarCategoriaCest
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

    private function ensureRoleAndAssignToUser(string $username, string $roleName): void
    {
        /** @var User|null $user */
        $user = User::findOne(['username' => $username]);
        if ($user === null) {
            throw new \RuntimeException("Utilizador da fixture não encontrado: {$username}");
        }

        $auth = Yii::$app->authManager;
        if ($auth === null) {
            throw new \RuntimeException('authManager não está configurado no backend.');
        }

        // Garantir que a role existe
        $role = $auth->getRole($roleName);
        if ($role === null) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
        }

        // Atribuir role ao utilizador se ainda não tiver
        $assignments = $auth->getAssignments((string)$user->id);
        if (!isset($assignments[$roleName])) {
            $auth->assign($role, (string)$user->id);
        }
    }

    private function loginAsAdminOrGestor(FunctionalTester $I): void
    {
        // Troca para 'gestorCasa' se for esse o nome real do role no teu projeto.
        $this->ensureRoleAndAssignToUser('erau', 'gestorCasa');

        // Login pela UI
        $I->amOnRoute('/site/login');

        $I->fillField('input[name="LoginForm[username]"]', 'erau');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');
        $I->click('button[name="login-button"]');

        // Indicador simples: saiu do ecrã de login
        $I->dontSeeElement('button[name="login-button"]');
    }

    public function createCategoria(FunctionalTester $I): void
    {
        $this->loginAsAdminOrGestor($I);

        $I->amOnRoute('categoria/create');
        $I->see('Create Categoria', 'h1');

        // Como Categoria::formName() devolve '', o input é name="nome"
        $I->fillField('input[name="nome"]', 'Mercearia');
        $I->click('Save');

        // Validar na BD via ActiveRecord (sem Db module)
        $I->seeRecord(Categoria::class, ['nome' => 'Mercearia']);

        // E validação mínima na UI
        $I->see('Mercearia');
    }

    public function createCategoriaValidationNomeObrigatorio(FunctionalTester $I): void
    {
        $this->loginAsAdminOrGestor($I);

        $I->amOnRoute('categoria/create');
        $I->click('Save');

        // Mensagem típica do Yii (pode variar se tens traduções)
        $I->see('cannot be blank');
    }

    public function updateCategoria(FunctionalTester $I): void
    {
        $this->loginAsAdminOrGestor($I);

        // 1) Criar uma categoria inicial diretamente na BD
        $categoriaId = $I->haveRecord(Categoria::class, [
            'nome' => 'Categoria Original',
        ]);

        // 2) Ir à página de update dessa categoria
        $I->amOnRoute('categoria/update', ['id' => $categoriaId]);
        $I->see('Update Categoria', 'h1');

        // 3) Alterar o nome e gravar
        $I->fillField('input[name="nome"]', 'Categoria Atualizada');
        $I->click('Save');

        // 4) Verificar na BD
        $I->seeRecord(Categoria::class, [
            'id'   => $categoriaId,
            'nome' => 'Categoria Atualizada',
        ]);

        // 5) Verificar na UI (por ex. na index/view)
        $I->see('Categoria Atualizada');
    }
}
