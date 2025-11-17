<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "casas_utilizadores".
 *
 * @property int $id
 * @property int $idUtilizador
 * @property int $idCasa
 *
 * @property Casas $idCasa0
 * @property User $idUtilizador0
 */
class CasaUtilizador extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'casas_utilizadores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUtilizador', 'idCasa'], 'required'],
            [['id', 'idUtilizador', 'idCasa'], 'integer'],
            [['id'], 'unique'],
            [['idUtilizador'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['idUtilizador' => 'id']],
            [['idCasa'], 'exist', 'skipOnError' => true, 'targetClass' => Casas::class, 'targetAttribute' => ['idCasa' => 'id']],
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
            'idCasa' => 'Id Casa',
        ];
    }

    /**
     * Gets query for [[IdCasa0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdCasa0()
    {
        return $this->hasOne(Casas::class, ['id' => 'idCasa']);
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
