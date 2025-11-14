<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "casas".
 *
 * @property int $id
 * @property string $nome
 * @property string $dataCriacao
 * @property int $idUtilizadorPrincipal
 *
 * @property CasasUtilizadores[] $casasUtilizadores
 * @property User $idUtilizadorPrincipal0
 * @property Locais[] $locais
 */
class Casa extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'casas';
    }

    public function rules()
    {
        return [
            [['nome', 'idUtilizadorPrincipal'], 'required'],
            [['id', 'idUtilizadorPrincipal'], 'integer'],
            [['dataCriacao'], 'safe'],
            [['nome'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [
                ['idUtilizadorPrincipal'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['idUtilizadorPrincipal' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'dataCriacao' => 'Data de Criação',
            'idUtilizadorPrincipal' => 'Utilizador Principal',
        ];
    }

    public function getCasasUtilizadores()
    {
        return $this->hasMany(CasasUtilizadores::class, ['idCasa' => 'id']);
    }

    public function getIdUtilizadorPrincipal0()
    {
        return $this->hasOne(User::class, ['id' => 'idUtilizadorPrincipal']);
    }

    public function getLocais()
    {
        return $this->hasMany(Locais::class, ['idCasa' => 'id']);
    }
}
