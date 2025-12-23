<?php

namespace common\models;

use Yii;
use common\models\Casa;

class Local extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'locais';
    }

    public function rules()
    {
        return [
            [['casa_id', 'nome'], 'required'],
            [['casa_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [
                ['casa_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Casa::class,
                'targetAttribute' => ['casa_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'casa_id' => 'Casa',
            'nome' => 'Nome',
        ];
    }

    /** 🔗 Local pertence a uma Casa */
    public function getCasa()
    {
        return $this->hasOne(Casa::class, ['id' => 'casa_id']);
    }

    /** 📦 Local tem vários StockProdutos */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProduto::class, ['local_id' => 'id']);
    }

    /** ✅ JSON direto para API */
    public function formName()
    {
        return '';
    }
}
