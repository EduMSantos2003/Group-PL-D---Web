<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Lista;

/**
 * ListaSearch represents the model behind the search form of `common\models\Lista`.
 */
class ListaSearch extends Lista
{
    /**
     * {@inheritdoc}
     */

    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'utilizador_id'], 'integer'],
            [['nome', 'tipo', 'dataCriacao'], 'safe'],
            [['totalEstimado'], 'number'],
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
        $query = Lista::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'utilizador_id' => $this->utilizador_id,
            'totalEstimado' => $this->totalEstimado,
            'dataCriacao' => $this->dataCriacao,
        ]);
        // 🔍 PESQUISA GLOBAL
        // 🔍 PESQUISA GLOBAL (texto, número e data)
        if ($this->globalSearch !== null && $this->globalSearch !== '') {

            // texto (nome, tipo)
            $query->orFilterWhere(['like', 'nome', $this->globalSearch])
                ->orFilterWhere(['like', 'tipo', $this->globalSearch]);

            // número (totalEstimado) - pesquisa parcial
        if (is_numeric(str_replace(',', '.', $this->globalSearch))) {
            $valor = str_replace(',', '.', $this->globalSearch);

            $query->orFilterWhere([
                'like',
                'CAST(totalEstimado AS CHAR)',
                $valor
            ]);
}

            // data (YYYY-MM-DD ou parte da data)
            $query->orFilterWhere([
                'like',
                'DATE(dataCriacao)',
                $this->globalSearch
            ]);
        }


        return $dataProvider;
    }
}
