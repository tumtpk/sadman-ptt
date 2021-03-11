<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EquipmentDisremark;

/**
 * EquipmentDisremarkSearch represents the model behind the search form of `app\models\EquipmentDisremark`.
 */
class EquipmentDisremarkSearch extends EquipmentDisremark
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_main', 'id_sub', 'id_disbursement'], 'integer'],
            [['disbursement_status'], 'safe'],
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
        $query = EquipmentDisremark::find();

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
            'id' => $this->id,
            'id_main' => $this->id_main,
            'id_sub' => $this->id_sub,
            'id_disbursement' => $this->id_disbursement,
        ]);

        $query->andFilterWhere(['like', 'disbursement_status', $this->disbursement_status]);

        return $dataProvider;
    }
}
