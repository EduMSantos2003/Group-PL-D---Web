<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locais".
 *
 * @property int $id
 * @property int $casa_id
 * @property string $nome
 *
 * @property Casas $casa
 * @property StockProdutos[] $stockProdutos
 */
class Local extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locais';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['casa_id', 'nome'], 'required'],
            [['casa_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['casa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Casa::class, 'targetAttribute' => ['casa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'casa_id' => 'Casa ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Casa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCasa()
    {
        return $this->hasOne(Casa::class, ['id' => 'casa_id']);
    }

    /**
     * Gets query for [[StockProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProduto::class, ['local_id' => 'id']);
    }

}
