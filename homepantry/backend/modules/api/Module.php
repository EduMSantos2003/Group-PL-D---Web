<?php

namespace backend\modules\api;

use Yii;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function () {

            // FORÇAR SEMPRE JSON
            Yii::$app->response->format = Response::FORMAT_JSON;

            // LIMPAR OUTPUT (evita lixo antes do JSON)
            if (ob_get_length()) {
                ob_clean();
            }
        });
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Autenticação por token Bearer
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => [
                'auth/login',
            ],
        ];

        return $behaviors;
    }
}
