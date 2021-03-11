<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "equipment_disbursement".
 *
 * @property int $id รหัส
 * @property int $id_main รหัสข้อมูลอุปกรณ์
 * @property int $id_sub รหัสข้อมูลหมายเลขอุปกรณ์
 * @property int $unit_id หน่วยที่เบิกจ่าย
 * @property string $date_time เวลาที่เบิกจ่าย
 */
class EquipmentDisbursement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_disbursement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_main', 'id_sub', 'unit_id', 'date_time'], 'required'],
            [['id_main', 'id_sub', 'unit_id','equipment_approve_status'], 'integer'],
            [['remark','remark_repatriate','equipment_approve_remark'], 'string', 'max' => 255],
            [['date_time_repatriate'], 'string', 'max' => 50],
            [['date_time','date_time_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_disbursement' => Yii::t('app', 'รหัส'),
            'id_main' => Yii::t('app', 'รหัสข้อมูลอุปกรณ์'),
            'id_sub' => Yii::t('app', 'รหัสข้อมูลหมายเลขอุปกรณ์'),
            'unit_id' => Yii::t('app', 'หน่วยที่เบิกจ่าย'),
            'date_time' => Yii::t('app', 'เวลาที่เบิกจ่าย'),
            'date_time_end' => Yii::t('app', 'เวลาที่คาดว่าจะคืน'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'date_time_repatriate' => Yii::t('app', 'เวลาที่ส่งคืน'),
            'remark_repatriate' => Yii::t('app', 'หมายเหตุส่งคืน'),
            'equipment_approve_status' => Yii::t('app', 'สถานะตรวจสอบการเบิกจ่าย'),
            'equipment_approve_remark' => Yii::t('app', 'หมายเหตุสถานะการเบิกจ่าย'),
        ];
    }
}
