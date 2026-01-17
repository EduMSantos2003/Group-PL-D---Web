<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\VerbFilter;

class MatematicaController extends ActiveController
{
    public $modelClass = 'common\models\Categoria';

    public function actionRaizdois()
    {
        return [
            'raizdois' => 1.41,
        ];
    }


}