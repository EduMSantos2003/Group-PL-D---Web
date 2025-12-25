<?php

namespace common\models;

use Yii;
use common\models\ListaProduto;
use yii\helpers\ArrayHelper;

class Lista extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'listas';
    }

    public function rules()
    {
        return [
            [['nome', 'tipo'], 'required'],
            [['totalEstimado'], 'number'],
            [['dataCriacao'], 'safe'],
            [['nome', 'tipo'], 'string', 'max' => 255],
            [['utilizador_id'], 'integer'],
            [['utilizador_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['utilizador_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'totalEstimado' => 'Total Estimado',
            'dataCriacao' => 'Data Criação',
        ];
    }

    /* =======================
     * RELAÇÕES
     * ======================= */

    public function getListaProdutos()
    {
        return $this->hasMany(ListaProduto::class, ['lista_id' => 'id']);
    }

    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }

    /* =======================
     * LÓGICA DE NEGÓCIO
     * ======================= */

    public function calcularTotal()
    {
        return $this->getListaProdutos()->sum('subTotal') ?? 0;
    }

    public function beforeSave($insert)
    {
        if ($insert && empty($this->utilizador_id) && !Yii::$app->user->isGuest) {
            $this->utilizador_id = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    public function fields()
    {
        $fields = parent::fields();

        // expor relações
        $fields['listaProdutos'] = 'listaProdutos';

        return $fields;
    }

    public function extraFields()
    {
        return ['listaProdutos'];
    }
}
