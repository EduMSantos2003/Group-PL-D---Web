<?php

namespace common\models;

use Yii;
use common\models\Local;

class Casa extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'casas';
    }

    public function rules()
    {
        return [
            [['nome', 'utilizadorPrincipal_id'], 'required'],
            [['utilizadorPrincipal_id'], 'integer'],
            [['dataCriacao'], 'safe'],
            [['nome'], 'string', 'max' => 255],
            [
                ['utilizadorPrincipal_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['utilizadorPrincipal_id' => 'id']
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->dataCriacao = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }


    public function getCasasUtilizadores()
    {
        return $this->hasMany(CasaUtilizador::class, ['casa_id' => 'id']);
    }

    public function getLocais()
    {
        return $this->hasMany(Local::class, ['casa_id' => 'id']);
    }

    public function getUtilizadorPrincipal()
    {
        return $this->hasOne(User::class, ['id' => 'utilizadorPrincipal_id']);
    }

    // API REST → aceitar JSON direto
    public function formName()
    {
        return '';
    }

}
