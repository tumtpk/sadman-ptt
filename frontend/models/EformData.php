<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eform_data".
 *
 * @property int $id
 * @property int $form_id
 * @property string $data
 * @property string $date_time
 */
class EformData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eform_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'data_json','eform_id'], 'required'],
            [['form_id','eform_id'], 'integer'],
            [['data_json'], 'string'],
            [['date_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'ประเภทข้อมูล',
            'eform_id' => 'รหัสฟอร์มที่เรียกใช้งาน',
            'data_json' => 'ข้อมูล',
            'date_time' => 'วันที่บันทึก/แก้ไข',
        ];
    }
}
