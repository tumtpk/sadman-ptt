<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OperatingArea;

/**
 * OperatingAreaSearch represents the model behind the search form of `app\models\OperatingArea`.
 */
class OperatingAreaSearch extends OperatingArea
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area_id', 'zone_id', 'user_create'], 'integer'],
            [['area_name', 'area_detail', 'area_remark', 'date_create'], 'safe'],
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
        $query = OperatingArea::find();

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
            'area_id' => $this->area_id,
            'zone_id' => $this->zone_id,
            'date_create' => $this->date_create,
            'user_create' => $this->user_create,
        ]);

        $query->andFilterWhere(['like', 'area_name', $this->area_name])
            ->andFilterWhere(['like', 'area_detail', $this->area_detail])
            ->andFilterWhere(['like', 'area_remark', $this->area_remark]);

        return $dataProvider;
    }
}
