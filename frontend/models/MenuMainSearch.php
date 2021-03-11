<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\MenuMain;

/**
 * MenuMainSearch represents the model behind the search form of `frontend\models\MenuMain`.
 */
class MenuMainSearch extends MenuMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['m_name', 'm_link', 'm_role', 'm_status'], 'safe'],
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
        $query = MenuMain::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [

                'pageSize' => 10,

            ],
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
        ]);

        $query->andFilterWhere(['like', 'm_name', $this->m_name])
        ->andFilterWhere(['like', 'm_link', $this->m_link])
        ->andFilterWhere(['like', 'm_role', $this->m_role])
        ->andFilterWhere(['like', 'm_status', $this->m_status]);

        return $dataProvider;
    }
}
