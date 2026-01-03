<?php


namespace common\models;

use Yii;
use common\models\Produto;

/**
 * This is the model class for table "lista_produtos".
 *
 * @property int $id
 * @property int $lista_id
 * @property int $produto_id
 * @property float $quantidade
 * @property float $precoUnitario
 * @property float $subTotal
 *
 * @property Lista $lista
 * @property Produto $produto
 */
class ListaProduto extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'lista_produtos';
    }

    public function rules()
    {
        return [
            [['lista_id', 'produto_id', 'quantidade'], 'required'],
            [['lista_id', 'produto_id'], 'integer'],
            [['quantidade', 'precoUnitario', 'subTotal'], 'number'],

            [['lista_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Lista::class,
                'targetAttribute' => ['lista_id' => 'id']
            ],
            [['produto_id'], 'exist',
                'skipOnError' => true,
                'targetClass' => Produto::class,
                'targetAttribute' => ['produto_id' => 'id']
            ],
        ];
    }



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lista_id' => 'Lista',
            'produto_id' => 'Produto',
            'quantidade' => 'Quantidade',
            'precoUnitario' => 'Preço Unitário',
            'subTotal' => 'Subtotal',
        ];
    }

    /* =======================
     * RELAÇÕES
     * ======================= */

    public function getLista()
    {
        return $this->hasOne(Lista::class, ['id' => 'lista_id']);
    }

    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }

    /* =======================
     * LÓGICA DE NEGÓCIO
     * ======================= */

    protected function calcularSubTotal()
    {
        return $this->quantidade * $this->precoUnitario;
    }

    public function beforeSave($insert)
    {
        if ($this->produto_id) {
            $produto = Produto::findOne($this->produto_id);
            if ($produto) {
                $this->precoUnitario = $produto->preco;
            }
        }

        $this->subTotal = $this->quantidade * $this->precoUnitario;

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        /* =======================
         * 1️⃣ Atualizar total da lista
         * ======================= */
        if ($this->lista) {
            $total = $this->lista->calcularTotal();
            Lista::updateAll(
                ['totalEstimado' => $total],
                ['id' => $this->lista_id]
            );
        }


        // MQTT – notificar alteração da lista (por lista_id)
        $mensagem = json_encode([
            'acao'        => $insert ? 'create' : 'update',
            'lista_id'    => $this->lista_id,
            'produto_id'  => $this->produto_id,
            'quantidade'  => $this->quantidade,
            'timestamp'   => date('Y-m-d H:i:s')
        ]);

        $cmd = 'mosquitto_pub -t lista/' . $this->lista_id . ' -m ' . escapeshellarg($mensagem);
        exec($cmd);

    }


    public function afterDelete()
    {
        parent::afterDelete();

        /* =======================
         * 1️⃣ Atualizar total da lista
         * ======================= */
        if ($this->lista) {
            $total = $this->lista->calcularTotal();
            Lista::updateAll(
                ['totalEstimado' => $total],
                ['id' => $this->lista_id]
            );
        }

        // MQTT – notificar remoção (por lista_id)
        $mensagem = json_encode([
            'acao'        => 'delete',
            'lista_id'    => $this->lista_id,
            'produto_id'  => $this->produto_id,
            'timestamp'   => date('Y-m-d H:i:s')
        ]);

        $cmd = 'mosquitto_pub -t lista/' . $this->lista_id . ' -m ' . escapeshellarg($mensagem);
        exec($cmd);
    }

}
