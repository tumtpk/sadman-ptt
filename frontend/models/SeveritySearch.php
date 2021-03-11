<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Severity;

/**
 * SeveritySearch represents the model behind the search form of `common\models\Severity`.
 */
class SeveritySearch extends Severity
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idseverity'], 'integer'],
            [['severity_name', 'severity_description'], 'safe'],
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
        $query = Severity::find();

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
            'idseverity' => $this->idseverity,
        ]);

        $query->andFilterWhere(['like', 'severity_name', $this->severity_name])
            ->andFilterWhere(['like', 'severity_description', $this->severity_description]);

        return $dataProvider;
    }
}
