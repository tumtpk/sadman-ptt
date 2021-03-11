<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Kptag;

/**
 * KptagSearch represents the model behind the search form of `common\models\Kptag`.
 */
class KptagSearch extends Kptag
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idkp_tag'], 'integer'],
            [['SP_KP', 'name_kp', 'remark'], 'safe'],
            [['UTM_Indian_N', 'UTM_Indian_E', 'UTM_WGS84_N', 'UTM_WGS84_E', 'GEO_WGS84_Lat', 'GEO_WGS84_Long', 'GEO_WGS84_2_Lat', 'GEO_WGS84_2_Long'], 'number'],
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
        $query = Kptag::find();

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
            'idkp_tag' => $this->idkp_tag,
            'UTM_Indian_N' => $this->UTM_Indian_N,
            'UTM_Indian_E' => $this->UTM_Indian_E,
            'UTM_WGS84_N' => $this->UTM_WGS84_N,
            'UTM_WGS84_E' => $this->UTM_WGS84_E,
            'GEO_WGS84_Lat' => $this->GEO_WGS84_Lat,
            'GEO_WGS84_Long' => $this->GEO_WGS84_Long,
            'GEO_WGS84_2_Lat' => $this->GEO_WGS84_2_Lat,
            'GEO_WGS84_2_Long' => $this->GEO_WGS84_2_Long,
        ]);

        $query->andFilterWhere(['like', 'SP_KP', $this->SP_KP])
            ->andFilterWhere(['like', 'name_kp', $this->name_kp])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
