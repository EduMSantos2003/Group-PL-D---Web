<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lista_produtos".
 *
 * @property int $id
 * @property int $lista_id
 * @property int $produto_id
 * @property float $quantidade
 * @property float $precoUnitario
 * @property float $subTotal
 *
 * @property Listas $lista
 * @property Produtos $produto
 */
class ListaProduto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lista_produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lista_id', 'produto_id', 'quantidade', 'precoUnitario', 'subTotal'], 'required'],
            [['lista_id', 'produto_id'], 'integer'],
            [['quantidade', 'precoUnitario', 'subTotal'], 'number'],
            [['lista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listas::class, 'targetAttribute' => ['lista_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lista_id' => 'Lista ID',
            'produto_id' => 'Produto ID',
            'quantidade' => 'Quantidade',
            'precoUnitario' => 'Preco Unitario',
            'subTotal' => 'Sub Total',
        ];
    }

    /**
     * Gets query for [[Lista]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLista()
    {
        return $this->hasOne(Listas::class, ['id' => 'lista_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produtos::class, ['id' => 'produto_id']);
    }

}
