<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "procedure".
 *
 * @property int $idprocedure
 * @property string $procedureName
 *
 * @property Invasionlist[] $invasionlists
 */
class Procedure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procedure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idprocedure', 'procedureName'], 'required'],
            [['idprocedure'], 'integer'],
            [['procedureName'], 'string', 'max' => 255],
            [['idprocedure'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idprocedure' => 'Idprocedure',
            'procedureName' => 'Procedure Name',
        ];
    }

    /**
     * Gets query for [[Invasionlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvasionlists()
    {
        return $this->hasMany(Invasionlist::className(), ['procedure_id' => 'idprocedure']);
    }
}
