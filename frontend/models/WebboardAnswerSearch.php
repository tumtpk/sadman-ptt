<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebboardAnswer;

/**
 * WebboardAnswerSearch represents the model behind the search form of `app\models\WebboardAnswer`.
 */
class WebboardAnswerSearch extends WebboardAnswer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer_id', 'answer_user_create'], 'integer'],
            [['answer_detail', 'answer_date_create', 'topic_id', 'status_del', 'key_images_or_file'], 'safe'],
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
        $query = WebboardAnswer::find();

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
            'answer_id' => $this->answer_id,
            'answer_user_create' => $this->answer_user_create,
        ]);

        $query->andFilterWhere(['like', 'answer_detail', $this->answer_detail])
            ->andFilterWhere(['like', 'answer_date_create', $this->answer_date_create])
            ->andFilterWhere(['like', 'topic_id', $this->topic_id])
            ->andFilterWhere(['like', 'status_del', $this->status_del])
            ->andFilterWhere(['like', 'key_images_or_file', $this->key_images_or_file]);

        return $dataProvider;
    }
}
