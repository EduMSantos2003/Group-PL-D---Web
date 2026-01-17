<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\Response;

use common\models\User;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // força JSON sempre
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }

    /**
     * POST /api/auth/login
     * Body:
     * {
     *   "username": "Admin",
     *   "password": "12345"
     * }
     */
    public function actionLogin()
    {
        $data = Yii::$app->request->bodyParams;

        if (empty($data['username']) || empty($data['password'])) {
            throw new BadRequestHttpException("Faltam username ou password");
        }

        $user = User::findByUsername($data['username']);

        if (!$user || !$user->validatePassword($data['password'])) {
            throw new UnauthorizedHttpException("Credenciais inválidas");
        }

        // gerar token simples e guardar na BD
        $token = Yii::$app->security->generateRandomString(40);
        $user->verification_token = $token;

        if (!$user->save(false)) {
            throw new BadRequestHttpException("Erro ao guardar token");
        }

        return [
            "user_id" => $user->id,
            "username" => $user->username,
            "token" => $token
        ];
    }
}
