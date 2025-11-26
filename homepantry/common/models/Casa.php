<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "casas".
 *
 * @property int $id
 * @property string $nome
 * @property string $dataCriacao
 * @property int $utilizadorPrincipal_id
 *
 * @property CasasUtilizadores[] $casasUtilizadores
 * @property Locais[] $locais
 * @property User $utilizadorPrincipal
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
            [['nome', 'utilizadorPrincipal_id'], 'required'],
            [['dataCriacao'], 'safe'],
            [['utilizadorPrincipal_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['utilizadorPrincipal_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizadorPrincipal_id' => 'id']],
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
            'utilizadorPrincipal_id' => 'Utilizador Principal ID',
        ];
    }

    /**
     * Gets query for [[CasasUtilizadores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCasasUtilizadores()
    {
        return $this->hasMany(CasasUtilizadores::class, ['casa_id' => 'id']);
    }

    /**
     * Gets query for [[Locais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocais()
    {
        return $this->hasMany(Locais::class, ['casa_id' => 'id']);
    }

    /**
     * Gets query for [[UtilizadorPrincipal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadorPrincipal()
    {
        return $this->hasOne(User::class, ['id' => 'utilizadorPrincipal_id']);
    }

}
