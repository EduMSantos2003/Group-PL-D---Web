<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;




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

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = [
            'categoria_id',
            'nome',
            'descricao',
            'unidade',
            'preco',
            'validade',
            'imageFile',
        ];

        $scenarios['update'] = [
            'categoria_id',
            'nome',
            'descricao',
            'unidade',
            'preco',
            'validade',
            'imageFile',
        ];

        return $scenarios;
    }


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

            [['categoria_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Categoria::class,
                'targetAttribute' => ['categoria_id' => 'id']
            ],

            // imagem SEMPRE opcional na API
            [['imageFile'], 'file',
                'extensions' => 'png, jpg, jpeg',
                'skipOnEmpty' => true
            ],
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

    // API REST → JSON direto
    public function formName()
    {
        return '';
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

        // 1) Garantir que o preço nunca é negativo
        if ($this->preco < 0) {
            $this->preco = 0;
        }

        // 2) Normalizar a data de validade (dd/MM/yyyy → Y-m-d)
        if (!empty($this->validade)) {

            // tenta formato do DatePicker (PT)
            $date = \DateTime::createFromFormat('d/m/Y', $this->validade);

            if ($date !== false) {
                $this->validade = $date->format('Y-m-d');
            } else {
                // fallback: se já vier em Y-m-d (ex: update)
                $date = \DateTime::createFromFormat('Y-m-d', $this->validade);
                if ($date !== false) {
                    $this->validade = $date->format('Y-m-d');
                }
            }
        }
        // Se um dia quiseres fazer mais alguma lógica antes de gravar,
        // podes acrescentar aqui, mas SEM usar campos que não existam na BD.

        return true;
    }


    public function upload()
    {
        if (!$this->imageFile) {
            return true; // IMPORTANTE no update sem imagem
        }

        if ($this->validate(['imageFile'])) {

            $uploadPath = Yii::getAlias('@frontend/web/uploads/produtos/');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $fileName = uniqid('prod_') . '.' . $this->imageFile->extension;

            if ($this->imageFile->saveAs($uploadPath . $fileName)) {
                $this->imagem = $fileName;
                return true;
            }
        }

        return false;
    }
}
