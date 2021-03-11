<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\MenuSub;

/**
 * MenuSubSearch represents the model behind the search form of `frontend\models\MenuSub`.
 */
class MenuSubSearch extends MenuSub
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submenu_id', 'menu_id'], 'integer'],
            [['submenu_name', 'submenu_role', 'submenu_link', 'submenu_active'], 'safe'],
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
        $query = MenuSub::find();

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
            'submenu_id' => $this->submenu_id,
            'menu_id' => $this->menu_id,
        ]);

        $query->andFilterWhere(['like', 'submenu_name', $this->submenu_name])
        ->andFilterWhere(['like', 'submenu_role', $this->submenu_role])
        ->andFilterWhere(['like', 'submenu_link', $this->submenu_link])
        ->andFilterWhere(['like', 'submenu_active', $this->submenu_active]);

        return $dataProvider;
    }
}
