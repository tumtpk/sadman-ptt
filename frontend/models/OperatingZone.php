<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operating_zone".
 *
 * @property int $id รหัสรายการ
 * @property string $zone_name รายการ
 * @property string|null $detail รายละเอียด
 * @property string|null $remark หมายเหตุ
 * @property string|null $date_create เวลาบันทึก
 * @property int $user_create หน่วยที่บันทึก
 */
class OperatingZone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operating_zone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_name', 'user_create'], 'required'],
            [['date_create'], 'safe'],
            [['user_create'], 'integer'],
            [['zone_name', 'detail', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสรายการ'),
            'zone_name' => Yii::t('app', 'รายการ'),
            'detail' => Yii::t('app', 'รายละเอียด'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'date_create' => Yii::t('app', 'เวลาบันทึก'),
            'user_create' => Yii::t('app', 'หน่วยที่บันทึก'),
        ];
    }
}
