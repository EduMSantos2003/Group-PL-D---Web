<?php

namespace backend\modules\api;

use Yii;
use yii\web\Response;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        // LIMPA QUALQUER OUTPUT ANTES DO JSON
        Yii::$app->response->on(Response::EVENT_BEFORE_SEND, function () {
            if (ob_get_length()) {
                ob_clean();
            }
        });
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }
}