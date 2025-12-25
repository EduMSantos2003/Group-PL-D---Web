<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "historico_precos".
 *
 * @property int $id
 * @property int $produto_id
 * @property float $preco
 * @property string $dataRegisto
 *
 * @property Produto $produto
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
            [['produto_id', 'preco'], 'required'],
            [['produto_id'], 'integer'],
            [['preco'], 'number'],
            [['dataRegisto'], 'safe'],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produto_id' => 'Produto ID',
            'preco' => 'Preco',
            'dataRegisto' => 'Data Registo',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }

    // API REST
    public function formName()
    {
        return '';
    }

}
