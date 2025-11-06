<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "casas".
 *
 * @property int $id
 * @property string $nome
 * @property string $dataCriacao
 * @property int $idUtilizadorPrincipal
 *
 * @property CasasUtilizadores[] $casasUtilizadores
 * @property Utilizadores $idUtilizadorPrincipal0
 * @property Locais[] $locais
 */
class Casa extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'casas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nome', 'idUtilizadorPrincipal'], 'required'],
            [['id', 'idUtilizadorPrincipal'], 'integer'],
            [['dataCriacao'], 'safe'],
            [['nome'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['idUtilizadorPrincipal'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizadores::class, 'targetAttribute' => ['idUtilizadorPrincipal' => 'id']],
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
            'dataCriacao' => 'Data Criacao',
            'idUtilizadorPrincipal' => 'Id Utilizador Principal',
        ];
    }

    /**
     * Gets query for [[CasasUtilizadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCasasUtilizadores()
    {
        return $this->hasMany(CasasUtilizadores::class, ['idCasa' => 'id']);
    }

    /**
     * Gets query for [[IdUtilizadorPrincipal0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUtilizadorPrincipal0()
    {
        return $this->hasOne(Utilizadores::class, ['id' => 'idUtilizadorPrincipal']);
    }

    /**
     * Gets query for [[Locais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocais()
    {
        return $this->hasMany(Locais::class, ['idCasa' => 'id']);
    }

}
