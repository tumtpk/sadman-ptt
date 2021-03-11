<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role', 'status'], 'integer'],
            [['name', 'username', 'password', 'auth_key', 'password_reset_token', 'user_group', 'images', 'email'], 'safe'],
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
        $unitid = (isset($_GET['unitid'])) ? $_GET['unitid'] : '';

        if (!empty($unitid)) {
         $query = Users::find()->where("unit_id = '".$unitid."'");
     }else{
        $query = Users::find();
    }

    

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
        'role' => $this->role,
        'status' => $this->status,
    ]);

    $query->andFilterWhere(['like', 'name', $this->name])
    ->andFilterWhere(['like', 'username', $this->username])
    ->andFilterWhere(['like', 'password', $this->password])
    ->andFilterWhere(['like', 'auth_key', $this->auth_key])
    ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
    ->andFilterWhere(['like', 'user_group', $this->user_group])
    ->andFilterWhere(['like', 'images', $this->images])
    ->andFilterWhere(['like', 'email', $this->email]);

    return $dataProvider;
}
}
