<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EformData;
use DateTime;
use Yii;
/**
 * EformDataSearch represents the model behind the search form of `app\models\EformData`.
 */
class EformDataSearch extends EformData
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'form_id'], 'integer'],
            [['data_json', 'date_time','eform_id'], 'safe'],
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

        $WHERE = ($_SESSION['user_role']=='1') ? "" : "WHERE unit_id LIKE '%\"".$_SESSION['unit_id']."\"%'";
        $sub = Yii::$app->db->createCommand("SELECT id FROM eform_template $WHERE")->queryAll();
        $column = array();
        foreach ($sub as $s) {
            $column[] = $s['id'];
        }

        $column = '("' . implode('","', $column) . '")';
        $column = str_replace('(', '', $column);
        $column = str_replace(')', '', $column);
        $column = str_replace('"', '\'', $column);

        $form_id = (isset($_GET['form_id'])) ? $_GET['form_id'] : '';

        $stay_informed = (isset($_GET['stay_informed'])) ? "AND data_json LIKE '%\"stay_informed\":\"".$_GET['stay_informed']."\"%'" : '';

        $eversion = (isset($_GET['eversion'])) ? "AND data_json LIKE '%\"form_id\":\"".$form_id."\",\"eform_id\":\"".$_GET['eform_id']."\",\"eform_version\":\"".$_GET['eversion']."\"%'" : '';

        $usercreate = ($_SESSION['user_role']=='3') ? "AND data_json LIKE '%\"user_create_id\":\"".$_SESSION['user_id']."\"%'" : "";

        if (!empty($form_id)) {

         $query = EformData::find()->where("form_id = '".$form_id."' AND eform_id IN (".$column.") $stay_informed $eversion $usercreate");
     }else{
        $query = EformData::find();
    }

        // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
        'query' => $query,
        'sort'=> ['defaultOrder' => ['date_time' => SORT_DESC]],
    ]);

    if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
        return $dataProvider;
    }

        // grid filtering conditions
    $query->andFilterWhere([
        'id' => $this->id,
        'form_id' => $this->form_id,
        // 'date_time' => $this->date_time,
    ]);

    $start = substr($this->date_time, 0, 10);


    $end = substr($this->eform_id, 0, 10);
    $enddate = new DateTime($end);
    $enddate->modify('+1 day');

    $query
    ->andFilterWhere(['like', 'data_json', $this->data_json])
    // ->andFilterWhere(['like', 'date_time', $this->date_time]);
    ->andFilterWhere(['between', 'date_time', $start, $enddate->format('Y-m-d')]);

    return $dataProvider;
}
}
