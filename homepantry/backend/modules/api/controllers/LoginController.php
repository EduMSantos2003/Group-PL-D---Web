<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

use common\models\User;

class LoginController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // 🔓 DESATIVAR ACCESS CONTROL APENAS AQUI
        unset($behaviors['access']);

        // permitir apenas POST
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * POST /api/login
     */
    public function actionIndex()
    {
        $body = Yii::$app->request->bodyParams;

        if (
            empty($body['password']) ||
            (empty($body['email']) && empty($body['username']))
        ) {
            throw new BadRequestHttpException('Username/email e password são obrigatórios.');
        }

        $user = User::find()
            ->where(['email' => $body['email'] ?? null])
            ->orWhere(['username' => $body['username'] ?? null])
            ->one();

        if ($user === null) {
            throw new UnauthorizedHttpException('Credenciais inválidas.');
        }

        if (!Yii::$app->security->validatePassword(
            $body['password'],
            $user->password_hash
        )) {
            throw new UnauthorizedHttpException('Credenciais inválidas.');
        }

        if ($user->status != 10) {
            throw new UnauthorizedHttpException('Utilizador inativo.');
        }

        return [
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role ?? null,
            ],
        ];
    }
}
