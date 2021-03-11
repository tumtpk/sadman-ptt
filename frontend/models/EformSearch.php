<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Eform;

/**
 * EformSearch represents the model behind the search form of `app\models\Eform`.
 */
class EformSearch extends Eform
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'form_id', 'version', 'active', 'unit_id'], 'integer'],
            [['form_element', 'detail'], 'safe'],
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
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Eform::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'form_id' => $this->form_id,
            'version' => $this->version,
            'active' => $this->active,
            'unit_id' => $this->unit_id,
        ]);

        $query->andFilterWhere(['like', 'form_element', $this->form_element])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }

    
}
