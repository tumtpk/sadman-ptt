<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsersReport;
use DateTime;
use Yii;
/**
 * UsersReportSearch represents the model behind the search form of `app\models\UsersReport`.
 */
class UsersReportSearch extends UsersReport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['data_json', 'user_create', 'date_record'], 'safe'],
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
        $this->load($params);

        if ($_SESSION['user_role']!="3") {
            $query = UsersReport::find();
        }else{
            $query = UsersReport::find()->where("user_create = '".$_SESSION['user_id']."'");
        }
        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $start = substr($this->data_json, 0, 10);

        $user_id = Yii::$app->db->createCommand("SELECT id FROM users WHERE name LIKE '%".$this->user_create."%'")->queryOne();
        $user_id = $user_id['id'];
        $end = substr($this->date_record, 0, 10);
        $enddate = new DateTime($end);
        $enddate->modify('+1 day');

        $query
            // ->andFilterWhere(['like', 'data_json', $this->data_json])
        ->andFilterWhere(['like', 'user_create', $user_id])
            // ->andFilterWhere(['like', 'date_record', $this->date_record]);
        ->andFilterWhere(['between', 'date_record', $start, $enddate->format('Y-m-d')]);

        return $dataProvider;
    }
}
