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

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Aqui só mexemos em campos que existem mesmo na tabela "produtos"

        // 1) Garantir que o preço nunca é negativo
        if ($this->preco < 0) {
            $this->preco = 0;
        }

        // 2) Normalizar a data de validade (opcional, se usares um datepicker já vem no formato certo)
        if (!empty($this->validade)) {
            // tenta converter qualquer formato legível para Y-m-d
            $time = strtotime($this->validade);
            if ($time !== false) {
                $this->validade = date('Y-m-d', $time);
            }
        }

        // Se um dia quiseres fazer mais alguma lógica antes de gravar,
        // podes acrescentar aqui, mas SEM usar campos que não existam na BD.

        return true;
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
