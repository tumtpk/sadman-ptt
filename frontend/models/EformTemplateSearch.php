<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EformTemplate;
use Yii;
/**
 * EformTemplateSearch represents the model behind the search form of `app\models\EformTemplate`.
 */
class EformTemplateSearch extends EformTemplate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'version'], 'integer'],
            [['form_element', 'detail'], 'safe'],
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
        $query = EformTemplate::find()->where("disable = '0'");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6, 
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
            'type' => $this->type,
            'version' => $this->version,
        ]);

        $query->andFilterWhere(['like', 'form_element', $this->form_element])
        ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }

    public function search_dashboard($params)
    {
        $this->load($params);

        if(!empty($this->detail)&& empty($this->version)){

            $sub = Yii::$app->db->createCommand("SELECT form_id FROM eform WHERE detail LIKE '%".$this->detail."%' AND unit_id = '".$_SESSION['unit_id']."'")->queryAll();
            $column = array();
            foreach ($sub as $s) {
                $column[] = $s['form_id'];
            }

            $column = '("' . implode('","', $column) . '")';
            $column = str_replace('(', '', $column);
            $column = str_replace(')', '', $column);
            $column = str_replace('"', '\'', $column);

            $query = EformTemplate::find()->where("disable = '0' AND id IN (".$column.")");

        }elseif (empty($this->detail) && !empty($this->version)) {

            $main = Yii::$app->db->createCommand("SELECT form_id FROM eform WHERE version = '".$this->version."' AND unit_id = '".$_SESSION['unit_id']."'")->queryAll();
            $column_id = array();
            foreach ($main as $m) {
                $column_id[] = $m['form_id'];
            }

            $column_id = '("' . implode('","', $column_id) . '")';
            $column_id = str_replace('(', '', $column_id);
            $column_id = str_replace(')', '', $column_id);
            $column_id = str_replace('"', '\'', $column_id);

            $query = EformTemplate::find()->where("disable = '0' AND id IN (".$column_id.")");

        }elseif (!empty($this->detail)&& !empty($this->version)) {

            $main = Yii::$app->db->createCommand("SELECT form_id FROM eform WHERE version = '".$this->version."' AND detail LIKE '%".$this->detail."%' AND unit_id = '".$_SESSION['unit_id']."'")->queryAll();
            $column_id = array();
            foreach ($main as $m) {
                $column_id[] = $m['form_id'];
            }

            $column_id = '("' . implode('","', $column_id) . '")';
            $column_id = str_replace('(', '', $column_id);
            $column_id = str_replace(')', '', $column_id);
            $column_id = str_replace('"', '\'', $column_id);

            $query = EformTemplate::find()->where("disable = '0' AND id IN (".$column_id.")");
            
        }else{

            $sub = Yii::$app->db->createCommand("SELECT form_id FROM eform WHERE unit_id = '".$_SESSION['unit_id']."'")->queryAll();
            $column = array();
            foreach ($sub as $s) {
                $column[] = $s['form_id'];
            }

            $column = '("' . implode('","', $column) . '")';
            $column = str_replace('(', '', $column);
            $column = str_replace(')', '', $column);
            $column = str_replace('"', '\'', $column);

            $query = EformTemplate::find()->where("disable = '0' AND id IN (".$column.")");
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6, 
            ],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'form_element', $this->form_element]);

        return $dataProvider;
    }
}
