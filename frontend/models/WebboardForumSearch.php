<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebboardForum;

/**
 * WebboardForumSearch represents the model behind the search form of `app\models\WebboardForum`.
 */
class WebboardForumSearch extends WebboardForum
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forum_id'], 'integer'],
            [['forum_name', 'forum_date_create', 'forum_user_create'], 'safe'],
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
        $query = WebboardForum::find();

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
            'forum_id' => $this->forum_id,
        ]);

        $query->andFilterWhere(['like', 'forum_name', $this->forum_name])
            ->andFilterWhere(['like', 'forum_date_create', $this->forum_date_create])
            ->andFilterWhere(['like', 'forum_user_create', $this->forum_user_create]);

        return $dataProvider;
    }
}
