<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "listas".
 *
 * @property int $id
 * @property int $idUtilizador
 * @property string $nome
 * @property string $tipo
 * @property float $totalEstimado
 * @property string $dataCriacao
 *
 * @property Utilizadores $idUtilizador0
 * @property ListaProdutos[] $listaProdutos
 */
class Lista extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUtilizador', 'nome', 'tipo'], 'required'],
            [['id', 'idUtilizador'], 'integer'],
            [['totalEstimado'], 'number'],
            [['dataCriacao'], 'safe'],
            [['nome', 'tipo'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['idUtilizador'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizadores::class, 'targetAttribute' => ['idUtilizador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idUtilizador' => 'Id Utilizador',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'totalEstimado' => 'Total Estimado',
            'dataCriacao' => 'Data Criacao',
        ];
    }

    /**
     * Gets query for [[IdUtilizador0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUtilizador0()
    {
        return $this->hasOne(Utilizadores::class, ['id' => 'idUtilizador']);
    }

    /**
     * Gets query for [[ListaProdutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListaProdutos()
    {
        return $this->hasMany(ListaProdutos::class, ['idLista' => 'id']);
    }

}
