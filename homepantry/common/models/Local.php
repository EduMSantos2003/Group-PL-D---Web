<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locais".
 *
 * @property int $id
 * @property int $idCasa
 * @property string $nome
 *
 * @property Casas $idCasa0
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
            [['id', 'idCasa', 'nome'], 'required'],
            [['id', 'idCasa'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['idCasa'], 'exist', 'skipOnError' => true, 'targetClass' => Casas::class, 'targetAttribute' => ['idCasa' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idCasa' => 'Id Casa',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[IdCasa0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCasa0()
    {
        return $this->hasOne(Casas::class, ['id' => 'idCasa']);
    }

    /**
     * Gets query for [[StockProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProdutos::class, ['idLocal' => 'id']);
    }

}
