<?php

namespace common\models;

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
 * @property HistoricoPreco[] $historicoPrecos
 * @property Categoria $idCategoria0
 * @property ListaProduto[] $listaProdutos
 * @property StockProduto[] $stockProdutos
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
            [['idCategoria', 'nome', 'descricao', 'unidade', 'preco', 'validade'], 'required'],
            [['id', 'idCategoria', 'unidade'], 'integer'],
            [['preco'], 'number'],
            [['validade'], 'safe'],
            [['nome', 'descricao'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['idCategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['idCategoria' => 'id']],
            [['imagem'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idCategoria' => 'Categoria',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'unidade' => 'Unidade',
            'preco' => 'Preco',
            'validade' => 'Validade',
            'imagem' => 'Imagem',
        ];
    }

    /**
     * Gets query for [[HistoricoPrecos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricoPrecos()
    {
        return $this->hasMany(HistoricoPreco::class, ['idProduto' => 'id']);
    }

    /**
     * Gets query for [[IdCategoria0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'idCategoria']);
    }

    /**
     * Gets query for [[ListaProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaProdutos()
    {
        return $this->hasMany(ListaProduto::class, ['idProduto' => 'id']);
    }

    /**
     * Gets query for [[StockProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProduto::class, ['idProduto' => 'id']);
    }

    public function getImagemUrl()
    {
        if (!empty($this->imagem)) {
            return '/img/produtos/' . $this->imagem;
        }

        return '/img/produtos/default.png';
    }




}
