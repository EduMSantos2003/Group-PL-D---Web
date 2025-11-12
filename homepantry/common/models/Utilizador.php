<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "utilizadores".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property string $password
 * @property string $dataRegisto
 *
 * @property Casas[] $casas
 * @property CasasUtilizadores[] $casasUtilizadores
 * @property Listas[] $listas
 * @property StockProdutos[] $stockProdutos
 */
class Utilizador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilizadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'password'], 'required'],
            [['id'], 'integer'],
            [['dataRegisto'], 'safe'],
            [['nome', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 80],
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
            'email' => 'Email',
            'password' => 'Password',
            'dataRegisto' => 'Data Registo',
        ];
    }

    /**
     * Gets query for [[Casas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCasas()
    {
        return $this->hasMany(Casas::class, ['idUtilizadorPrincipal' => 'id']);
    }

    /**
     * Gets query for [[CasasUtilizadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCasasUtilizadores()
    {
        return $this->hasMany(CasasUtilizadores::class, ['idUtilizador' => 'id']);
    }

    /**
     * Gets query for [[Listas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListas()
    {
        return $this->hasMany(Listas::class, ['idUtilizador' => 'id']);
    }

    /**
     * Gets query for [[StockProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStockProdutos()
    {
        return $this->hasMany(StockProdutos::class, ['idUtilizador' => 'id']);
    }

}
