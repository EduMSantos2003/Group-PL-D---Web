<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "historico_precos".
 *
 * @property int $id
 * @property int $idProduto
 * @property float $preco
 * @property string $dataRegisto
 *
 * @property Produtos $idProduto0
 */
class HistoricoPreco extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historico_precos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idProduto', 'preco'], 'required'],
            [['id', 'idProduto'], 'integer'],
            [['preco'], 'number'],
            [['dataRegisto'], 'safe'],
            [['id'], 'unique'],
            [['idProduto'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['idProduto' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idProduto' => 'Id Produto',
            'preco' => 'Preco',
            'dataRegisto' => 'Data Registo',
        ];
    }

    /**
     * Gets query for [[IdProduto0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduto0()
    {
        return $this->hasOne(Produtos::class, ['id' => 'idProduto']);
    }

}
