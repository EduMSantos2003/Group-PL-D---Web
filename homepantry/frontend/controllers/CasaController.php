<?php

namespace frontend\controllers;


class CasaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
