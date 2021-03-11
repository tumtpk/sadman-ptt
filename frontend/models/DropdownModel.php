<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dropdown_model".
 *
 * @property int $id
 * @property string $model_name
 * @property string $description
 */
class DropdownModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dropdown_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_name','name','_id', 'description'], 'required'],
            [['model_name'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_name' => Yii::t('app', 'ชื่อตาราง (Model)'),
            'description' => Yii::t('app', 'คำอธิบาย'),
            'name' => Yii::t('app', 'คอลัมน์'),
            '_id' => Yii::t('app', 'ชื่อ ID'),
        ];
    }
}
