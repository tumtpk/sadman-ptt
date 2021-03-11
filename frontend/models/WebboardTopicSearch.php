<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebboardTopic;

/**
 * WebboardTopicSearch represents the model behind the search form of `app\models\WebboardTopic`.
 */
class WebboardTopicSearch extends WebboardTopic
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_id'], 'integer'],
            [['topic_name', 'topic_detail', 'topic_view', 'topic_reply', 'topic_date_create', 'topic_user_create', 'forum_id', 'status_del', 'key_images_or_file'], 'safe'],
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
        $query = WebboardTopic::find();

        $user_create = (isset($_GET['user_create'])) ? $_GET['user_create'] : '';

        if (!empty($user_create)) {
           $query = WebboardTopic::find()->where("topic_user_create = '".$user_create."'");
        }else{
            if ($_SESSION['user_role']=='1') {
                $query = WebboardTopic::find();
            }else{
                $query = WebboardTopic::find()->where("status_del = '1'");
            }
            
        }

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
        'topic_id' => $this->topic_id,
    ]);

    $query->andFilterWhere(['like', 'topic_name', $this->topic_name])
    ->andFilterWhere(['like', 'topic_detail', $this->topic_detail])
    ->andFilterWhere(['like', 'topic_view', $this->topic_view])
    ->andFilterWhere(['like', 'topic_reply', $this->topic_reply])
    ->andFilterWhere(['like', 'topic_date_create', $this->topic_date_create])
    ->andFilterWhere(['like', 'topic_user_create', $this->topic_user_create])
    ->andFilterWhere(['like', 'forum_id', $this->forum_id])
    ->andFilterWhere(['like', 'status_del', $this->status_del])
    ->andFilterWhere(['like', 'key_images_or_file', $this->key_images_or_file]);

    return $dataProvider;
}
}
