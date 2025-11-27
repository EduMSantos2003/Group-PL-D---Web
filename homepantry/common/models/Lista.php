<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "listas".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property string $nome
 * @property string $tipo
 * @property float $totalEstimado
 * @property string $dataCriacao
 *
 * @property ListaProdutos[] $listaProdutos
 * @property User $utilizador
 */
class Lista extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'tipo', 'totalEstimado'], 'required'],
            //[['utilizador_id'], 'integer'],
            [['totalEstimado'], 'number'],
            [['dataCriacao'], 'safe'],
            [['nome', 'tipo'], 'string', 'max' => 255],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'utilizador_id' => 'Utilizador ID',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'totalEstimado' => 'Total Estimado',
            'dataCriacao' => 'Data Criacao',
        ];
    }

    /**
     * Gets query for [[ListaProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaProdutos()
    {
        return $this->hasMany(ListaProdutos::class, ['lista_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }
    public function beforeSave($insert)
    {
        if ($insert) {
            if (empty($this->utilizador_id) && !\Yii::$app->user->isGuest) {
                $this->utilizador_id = \Yii::$app->user->id;
            }

            if (empty($this->dataCriacao)) {
                $this->dataCriacao = date('Y-m-d H:i:s');
            }
        }

        return parent::beforeSave($insert);
    }
}
