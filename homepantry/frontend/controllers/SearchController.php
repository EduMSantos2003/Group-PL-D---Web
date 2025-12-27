<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Produto;
use common\models\Categoria;
use common\models\Lista;
use common\models\Local;

class SearchController extends Controller
{
    public function actionIndex($q = null)
    {
        if ($q === '') {
            return $this->render('index', [
                'q' => $q,
                'produtos' => [],
                'categorias' => [],
                'listas' => [],
                'locais' => [],
            ]);
        }

        $produtos = Produto::find()
            ->where(['like', 'nome', $q])
            ->all();

        $categorias = Categoria::find()
            ->where(['like', 'nome', $q])
            ->all();

        $listas = Lista::find()
            ->where(['like', 'nome', $q])
            ->all();

        $locais = Local::find()
            ->where(['like', 'nome', $q])
            ->all();

        return $this->render('index', [
            'q' => $q,
            'produtos' => $produtos,
            'categorias' => $categorias,
            'listas' => $listas,
            'locais' => $locais,
        ]);
    }
}
