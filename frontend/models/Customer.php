<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $cus_id รหัส
 * @property string $cus_serial_number SerialNumber
 * @property string $cus_key Key
 * @property string $cus_basic Basic
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cus_serial_number', 'cus_key', 'cus_basic'], 'required'],
            [['user_create'], 'integer'],
            [['cus_serial_number', 'cus_key', 'cus_basic'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cus_id' => 'รหัส',
            'cus_serial_number' => 'SerialNumber',
            'cus_key' => 'Key',
            'cus_basic' => 'Basic',
            'user_create' => 'ผู้บันทึก',
        ];
    }
}
