<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_sn".
 *
 * @property int $id รหัสรายการ
 * @property int $id_main รหัสข้อมูลอุปกรณ์
 * @property string $serial_number หมายเลขเครื่อง
 * @property int $status สถานะ
 */
class EquipmentSn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_sn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_main', 'serial_number'], 'required'],
            [['id_main', 'status'], 'integer'],
            [['serial_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสรายการ'),
            'id_main' => Yii::t('app', 'ข้อมูลอุปกรณ์'),
            'serial_number' => Yii::t('app', 'หมายเลขเครื่อง'),
            'status' => Yii::t('app', 'สถานะ'),
        ];
    }
}
