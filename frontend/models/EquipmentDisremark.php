<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_disremark".
 *
 * @property int $id รหัส
 * @property int $id_main รหัสอุปกรณ์
 * @property int $id_sub รหัสเครื่องอุปกรณ์
 * @property int $id_disbursement รหัสการเบิกจ่ายอุปกรณ์
 * @property string $disbursement_status รายละเอียดสถานการณ์
 * @property string $date_create เวลาที่บันทึก
 */
class EquipmentDisremark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_disremark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_main', 'id_sub', 'id_disbursement', 'disbursement_status', 'date_create'], 'required'],
            [['id_main', 'id_sub', 'id_disbursement'], 'integer'],
            [['disbursement_status'], 'string'],
            [['date_create'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัส'),
            'id_main' => Yii::t('app', 'รหัสอุปกรณ์'),
            'id_sub' => Yii::t('app', 'รหัสเครื่องอุปกรณ์'),
            'id_disbursement' => Yii::t('app', 'รหัสการเบิกจ่ายอุปกรณ์'),
            'disbursement_status' => Yii::t('app', 'รายละเอียดสถานการณ์'),
            'date_create' => Yii::t('app', 'เวลาที่บันทึก'),
        ];
    }
}
