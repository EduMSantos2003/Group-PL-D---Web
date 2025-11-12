<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lista_produtos".
 *
 * @property int $id
 * @property int $idLista
 * @property int $idProduto
 * @property float $quantidade
 * @property float $precoUnitario
 * @property float $subTotal
 *
 * @property Listas $idLista0
 * @property Produtos $idProduto0
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
            [['idLista', 'idProduto', 'quantidade', 'precoUnitario', 'subTotal'], 'required'],
            [['id', 'idLista', 'idProduto'], 'integer'],
            [['quantidade', 'precoUnitario', 'subTotal'], 'number'],
            [['id'], 'unique'],
            [['idLista'], 'exist', 'skipOnError' => true, 'targetClass' => Listas::class, 'targetAttribute' => ['idLista' => 'id']],
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
            'idLista' => 'Id Lista',
            'idProduto' => 'Id Produto',
            'quantidade' => 'Quantidade',
            'precoUnitario' => 'Preco Unitario',
            'subTotal' => 'Sub Total',
        ];
    }

    /**
     * Gets query for [[IdLista0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdLista0()
    {
        return $this->hasOne(Listas::class, ['id' => 'idLista']);
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
