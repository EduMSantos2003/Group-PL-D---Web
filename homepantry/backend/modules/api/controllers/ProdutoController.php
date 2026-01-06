<?php



namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ConflictHttpException;
use yii\db\IntegrityException;
use Throwable;





class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']); // 👈 FUNDAMENTAL
        return $actions;
    }

    public function actionDelete($id)
    {
        try {
            $model = \common\models\Produto::findOne($id);

            if ($model === null) {
                throw new NotFoundHttpException('Produto não encontrado.');
            }
            $model->delete();

            Yii::$app->response->statusCode = 200;
            return ['message' => 'Produto apagado com sucesso'];

        } catch (IntegrityException $e) {

            throw new ConflictHttpException(
                'Não é possível apagar o produto porque está associado a listas, stock ou histórico.'
            );

        } catch (Throwable $e) {
            throw $e;
        }
    }
}
