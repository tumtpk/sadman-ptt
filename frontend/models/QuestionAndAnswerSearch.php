<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\QuestionAndAnswer;

/**
 * QuestionAndAnswerSearch represents the model behind the search form of `app\models\QuestionAndAnswer`.
 */
class QuestionAndAnswerSearch extends QuestionAndAnswer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qa_id', 'qa_status', 'qa_slot'], 'integer'],
            [['qa_questions', 'qa_answer', 'qa_date_create'], 'safe'],
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
        $query = QuestionAndAnswer::find();

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
            'qa_id' => $this->qa_id,
            'qa_date_create' => $this->qa_date_create,
            'qa_status' => $this->qa_status,
            'qa_slot' => $this->qa_slot,
        ]);

        $query->andFilterWhere(['like', 'qa_questions', $this->qa_questions])
            ->andFilterWhere(['like', 'qa_answer', $this->qa_answer]);

        return $dataProvider;
    }
}
