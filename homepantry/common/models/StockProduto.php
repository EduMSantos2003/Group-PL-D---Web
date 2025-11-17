<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_produtos".
 *
 * @property int $id
 * @property int $idProduto
 * @property int $idUtilizador
 * @property int $idLocal
 * @property float $quantidade
 * @property string $validade
 * @property float $preco
 * @property string $dataCriacao
 *
 * @property Locais $idLocal0
 * @property Produtos $idProduto0
 * @property User $idUtilizador0
 */
class StockProduto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock_produtos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idProduto', 'idUtilizador', 'idLocal', 'quantidade', 'validade', 'preco'], 'required'],
            [['id', 'idProduto', 'idUtilizador', 'idLocal'], 'integer'],
            [['quantidade', 'preco'], 'number'],
            [['validade', 'dataCriacao'], 'safe'],
            [['id'], 'unique'],
            [['idProduto'], 'exist', 'skipOnError' => true, 'targetClass' => Produtos::class, 'targetAttribute' => ['idProduto' => 'id']],
            [['idUtilizador'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['idUtilizador' => 'id']],
            [['idLocal'], 'exist', 'skipOnError' => true, 'targetClass' => Locais::class, 'targetAttribute' => ['idLocal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idProduto' => 'Id Produto',
            'idUtilizador' => 'Id Utilizador',
            'idLocal' => 'Id Local',
            'quantidade' => 'Quantidade',
            'validade' => 'Validade',
            'preco' => 'Preco',
            'dataCriacao' => 'Data Criacao',
        ];
    }

    /**
     * Gets query for [[IdLocal0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocal0()
    {
        return $this->hasOne(Locais::class, ['id' => 'idLocal']);
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

    /**
     * Gets query for [[IdUtilizador0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUtilizador0()
    {
        return $this->hasOne(User::class, ['id' => 'idUtilizador']);
    }

}
