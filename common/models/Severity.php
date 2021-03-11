<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "severity".
 *
 * @property int $idseverity
 * @property string $severity_name
 * @property string|null $severity_description
 *
 * @property Invasionlist[] $invasionlists
 */
class Severity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'severity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['severity_name'], 'required'],
            [['severity_name', 'severity_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idseverity' => 'Idseverity',
            'severity_name' => 'Severity Name',
            'severity_description' => 'Severity Description',
        ];
    }

    /**
     * Gets query for [[Invasionlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvasionlists()
    {
        return $this->hasMany(Invasionlist::className(), ['severity' => 'idseverity']);
    }
}
