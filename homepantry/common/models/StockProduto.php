<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock_produtos".
 *
 * @property int $id
 * @property int $produto_id
 * @property int $utilizador_id
 * @property int $local_id
 * @property float $quantidade
 * @property string $validade
 * @property float $preco
 * @property string $dataCriacao
 *
 * @property Local $local
 * @property Produto $produto
 * @property User $utilizador
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
            [['produto_id', 'utilizador_id', 'local_id', 'quantidade', 'validade', 'preco'], 'required'],
            [['produto_id', 'utilizador_id', 'local_id'], 'integer'],
            [['quantidade', 'preco'], 'number'],
            [['validade', 'dataCriacao'], 'safe'],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['local_id'], 'exist', 'skipOnError' => true, 'targetClass' => Local::class, 'targetAttribute' => ['local_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produto_id' => 'Produto ID',
            'utilizador_id' => 'Utilizador ID',
            'local_id' => 'Local ID',
            'quantidade' => 'Quantidade',
            'validade' => 'Validade',
            'preco' => 'Preco',
            'dataCriacao' => 'Data Criacao',
        ];
    }

    /**
     * Gets query for [[Local]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocal()
    {
        return $this->hasOne(Local::class, ['id' => 'local_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!array_key_exists('quantidade', $changedAttributes)) {
            return;
        }

        // carregar local com casa
        $local = Local::find()
            ->with('casa')
            ->where(['id' => $this->local_id])
            ->one();

        if (!$local || !$local->casa) {
            return;
        }

        $casaId = $local->casa->id;

        $mensagem = json_encode([
            'produto_id' => $this->produto_id,
            'quantidade' => $this->quantidade,
            'local_id'   => $this->local_id,
            'casa_id'    => $casaId,
            'timestamp'  => date('Y-m-d H:i:s'),
        ]);

        $cmd = '"C:\Program Files\mosquitto\mosquitto_pub" '
            . '-t casa/' . $casaId . '/stock '
            . '-m ' . escapeshellarg($mensagem);

        exec($cmd);
    }




    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
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
