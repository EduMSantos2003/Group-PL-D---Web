<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int $idCategoria
 * @property string $nome
 * @property string $descricao
 * @property int $unidade
 * @property float $preco
 * @property string $validade
 *
 * @property HistoricoPrecos[] $historicoPrecos
 * @property Categorias $idCategoria0
 * @property ListaProdutos[] $listaProdutos
 * @property StockProdutos[] $stockProdutos
 */
class Produto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idCategoria', 'nome', 'descricao', 'unidade', 'preco', 'validade'], 'required'],
            [['id', 'idCategoria', 'unidade'], 'integer'],
            [['preco'], 'number'],
            [['validade'], 'safe'],
            [['nome', 'descricao'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['idCategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['idCategoria' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idCategoria' => 'Id Categoria',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'unidade' => 'Unidade',
            'preco' => 'Preco',
            'validade' => 'Validade',
        ];
    }

    /**
     * Gets query for [[HistoricoPrecos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricoPrecos()
    {
        return $this->hasMany(HistoricoPrecos::class, ['idProduto' => 'id']);
    }

    /**
     * Gets query for [[IdCategoria0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria0()
    {
        return $this->hasOne(Categorias::class, ['id' => 'idCategoria']);
    }

    /**
     * Gets query for [[ListaProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaProdutos()
    {
        return $this->hasMany(ListaProdutos::class, ['idProduto' => 'id']);
    }

    /**
     * Gets query for [[StockProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProdutos::class, ['idProduto' => 'id']);
    }

}
