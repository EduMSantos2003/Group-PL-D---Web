<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Produto;

/**
 * ProdutoSearch represents the model behind the search form of `common\models\Produto`.
 */
class ProdutoSearch extends Produto
{
    /**
     * {@inheritdoc}
     */

    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'categoria_id', 'unidade'], 'integer'],
            [['nome', 'descricao', 'validade', 'imagem'], 'safe'],
            [['preco'], 'number'],
            [['globalSearch'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Produto::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // 🔍 PESQUISA GLOBAL (texto, número e data)
        if ($this->globalSearch !== null && $this->globalSearch !== '') {

            // texto
            $query->orFilterWhere(['like', 'nome', $this->globalSearch])
                ->orFilterWhere(['like', 'descricao', $this->globalSearch]);

            // número (preço) - flexível
            $valor = str_replace(',', '.', $this->globalSearch);
            if (is_numeric($valor)) {
                $query->orFilterWhere([
                    'like',
                    'CAST(preco AS CHAR)',
                    $valor
                ]);
            }

            // data (validade)
            $query->orFilterWhere([
                'like',
                'validade',
                $this->globalSearch
            ]);
        }

        return $dataProvider;
    }

}
