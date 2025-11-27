<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * Inicializa RBAC: cria roles e permissões base.
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // limpa tudo, para evitar duplicados em testes
        $auth->removeAll();

        // ---------- PERMISSÕES ----------
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Gerir utilizadores';
        $auth->add($manageUsers);

        $manageCasas = $auth->createPermission('manageCasas');
        $manageCasas->description = 'Gerir casas';
        $auth->add($manageCasas);

        $manageStock = $auth->createPermission('manageStock');
        $manageStock->description = 'Gerir stock de produtos';
        $auth->add($manageStock);

        $viewStock = $auth->createPermission('viewStock');
        $viewStock->description = 'Ver stock de produtos';
        $auth->add($viewStock);

        $manageListas = $auth->createPermission('manageListas');
        $manageListas->description = 'Gerir listas de compras';
        $auth->add($manageListas);

        // ---------- ROLES ----------
        // convidado -> só ver stock
        $convidado = $auth->createRole('convidado');
        $auth->add($convidado);
        $auth->addChild($convidado, $viewStock);

        // membroCasa -> convidado + gerir listas
        $membroCasa = $auth->createRole('membroCasa');
        $auth->add($membroCasa);
        $auth->addChild($membroCasa, $convidado);
        $auth->addChild($membroCasa, $manageListas);

        // gestorCasa -> membroCasa + gerir stock + gerir casas
        $gestorCasa = $auth->createRole('gestorCasa');
        $auth->add($gestorCasa);
        $auth->addChild($gestorCasa, $membroCasa);
        $auth->addChild($gestorCasa, $manageStock);
        $auth->addChild($gestorCasa, $manageCasas);

        // admin -> gestorCasa + gerir utilizadores
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $gestorCasa);
        $auth->addChild($admin, $manageUsers);

        echo "RBAC inicializado com sucesso.\n";
    }
    // console/controllers/RbacController.php

    public function actionAssignAdmin($userId)
    {
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');

        if ($adminRole === null) {
            echo "Role 'admin' não existe. Corre primeiro php yii rbac/init\n";
            return;
        }

        $auth->assign($adminRole, $userId);
        echo "Utilizador {$userId} agora é admin.\n";
    }
}


