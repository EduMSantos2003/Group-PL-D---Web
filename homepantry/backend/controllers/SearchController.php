<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex($q = null)
    {
        if (!$q) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        $q = mb_strtolower(trim($q));

        $map = [

            // BACKEND
            'casa' => ['casa/index'],
            'casas' => ['casa/index'],

            'utilizador' => ['user/index'],
            'utilizadores' => ['user/index'],

            'categoria' => ['categoria/index'],
            'categorias' => ['categoria/index'],

            'local' => ['local/index'],
            'locais' => ['local/index'],

            // FRONTEND (sem pretty URL)
            'lista' => 'frontend:lista/index',
            'listas' => 'frontend:lista/index',

            'despensa' => 'frontend:stock-produto/index',
            'stock' => 'frontend:stock-produto/index',

            'produto' => 'frontend:produto/index',
            'produtos' => 'frontend:produto/index',
        ];

        foreach ($map as $key => $route) {
            if (str_contains($q, $key)) {

                // FRONTEND
                if (is_string($route) && str_starts_with($route, 'frontend:')) {
                    $path = str_replace('frontend:', '', $route);

                    return $this->redirect(
                        Yii::$app->urlManagerFrontend->createUrl([
                            'index.php',
                            'r' => $path
                        ])
                    );
                }

                // BACKEND
                return $this->redirect([
                    'index.php',
                    'r' => $route[0]
                ]);
            }
        }

        Yii::$app->session->setFlash(
            'warning',
            'Nenhum menu encontrado para "' . $q . '"'
        );

        return $this->redirect(Yii::$app->request->referrer);
    }
}
