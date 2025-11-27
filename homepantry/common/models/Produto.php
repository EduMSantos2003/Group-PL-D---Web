<?php

namespace common\models;

use Yii;



/**
 * This is the model class for table "produtos".
 *
 * @property int $id
 * @property int $categoria_id
 * @property string $nome
 * @property string $descricao
 * @property int $unidade
 * @property float $preco
 * @property string $validade
 * @property string $imagem
 *
 * @property Categoria $categoria
 * @property HistoricoPreco[] $historicoPrecos
 * @property ListaProduto[] $listaProdutos
 * @property StockProduto[] $stockProdutos
 */
class Produto extends \yii\db\ActiveRecord
{


    public $imageFile;

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
            [['categoria_id', 'nome', 'descricao', 'unidade', 'preco', 'validade'], 'required'],
            [['categoria_id', 'unidade'], 'integer'],
            [['preco'], 'number'],
            [['validade'], 'safe'],
            [['nome', 'descricao', 'imagem'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            //img file
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoria_id' => 'Categoria ID',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'unidade' => 'Unidade',
            'preco' => 'Preco',
            'validade' => 'Validade',
            'imagem' => 'Imagem',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[HistoricoPrecos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoricoPrecos()
    {
        return $this->hasMany(HistoricoPreco::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[ListaProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaProdutos()
    {
        return $this->hasMany(ListaProduto::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[StockProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProduto::class, ['produto_id' => 'id']);
    }


    public function upload()
    {
        if ($this->validate()) {
            // caminho onde a imagem será salva
            $filePath = 'uploads/produtos/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;

            // guarda a imagem
            $this->imageFile->saveAs($filePath);

            // se quiseres guardar o nome no BD
            $this->imagem = $filePath;

            return true;
        } else {
            return false;
        }
    }


}
