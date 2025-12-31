<?php

namespace common\models;

use common\models\Casa;
use common\models\User;
use Yii;

/**
 * This is the model class for table "casas_utilizadores".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $casa_id
 *
 * @property Casa $casa
 * @property User $utilizador
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
            [['utilizador_id', 'casa_id'], 'required'],
            [['utilizador_id', 'casa_id'], 'integer'],
            [['casa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Casa::class, 'targetAttribute' => ['casa_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizador_id' => 'Utilizador ID',
            'casa_id' => 'Casa ID',
        ];
    }

    /**
     * Gets query for [[Casa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCasa()
    {
        return $this->hasOne(Casa::class, ['id' => 'casa_id']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }

}
