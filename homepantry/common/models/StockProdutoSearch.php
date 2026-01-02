<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class StockProdutoSearch extends StockProduto
{
    /**  Campo virtual para pesquisa global */
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'produto_id', 'utilizador_id', 'local_id'], 'integer'],
            [['quantidade', 'preco'], 'number'],
            [['validade', 'dataCriacao'], 'safe'],
            [['globalSearch'], 'safe'], //  MUITO IMPORTANTE
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $formName = null)
    {
        $query = StockProduto::find()
            ->joinWith(['produto', 'utilizador', 'local']);

        // Ordenar por data de criação (opcional)
        $query->orderBy(['dataCriacao' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        /**  PESQUISA GLOBAL */
        if (is_numeric($this->globalSearch)) {
            $query->andFilterWhere([
                'or',
                ['quantidade' => $this->globalSearch],
                ['like', 'produtos.nome', $this->globalSearch],
                ['like', 'user.username', $this->globalSearch],
                ['like', 'locais.nome', $this->globalSearch],
            ]);
        } else {
            $query->andFilterWhere([
                'or',
                ['like', 'produtos.nome', $this->globalSearch],
                ['like', 'user.username', $this->globalSearch],
                ['like', 'locais.nome', $this->globalSearch],
            ]);
        }


        return $dataProvider;
    }
}
