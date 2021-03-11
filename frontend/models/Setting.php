<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $setting_name
 * @property string $setting_value
 * @property int $setting_status
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_name', 'setting_value' ], 'required'],
            [['setting_status', 'user_create'], 'integer'],
            [['setting_name'], 'string', 'max' => 50],
            [['setting_value'], 'string', 'max' => 3000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setting_name' => 'ชื่อตัวแปร (Setting Name)',
            'setting_value' => 'ค่าตัวแปร (Setting Value)',
            'setting_status' => 'สถานะ (Setting Status)',
            'user_create' => 'ผู้บันทึก',
        ];
    }
}
