<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "summary_type".
 *
 * @property int $id
 * @property string $type
 * @property string $detail
 */
class SummaryType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'summary_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'detail'], 'required'],
            [['type', 'detail'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'detail' => Yii::t('app', 'Detail'),
        ];
    }
}
