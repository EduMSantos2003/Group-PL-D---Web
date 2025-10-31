<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "casas".
 *
 * @property int $id
 * @property string $nome
 * @property string $dataCriacao
 * @property int $idUtilizadorPrincipial
 *
 * @property CasasUtilizadores[] $casasUtilizadores
 * @property Utilizadores $idUtilizadorPrincipial0
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
            [['id', 'nome', 'idUtilizadorPrincipial'], 'required'],
            [['id', 'idUtilizadorPrincipial'], 'integer'],
            [['dataCriacao'], 'safe'],
            [['nome'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['idUtilizadorPrincipial'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizadores::class, 'targetAttribute' => ['idUtilizadorPrincipial' => 'id']],
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
            'idUtilizadorPrincipial' => 'Id Utilizador Principial',
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
     * Gets query for [[IdUtilizadorPrincipial0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUtilizadorPrincipial0()
    {
        return $this->hasOne(Utilizadores::class, ['id' => 'idUtilizadorPrincipial']);
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
