<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id
 * @property string $nome
 *
 * @property Produtos[] $produtos
 */
class Categoria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nome'], 'required'],
            [['id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produtos::class, ['idCategoria' => 'id']);
    }

}
