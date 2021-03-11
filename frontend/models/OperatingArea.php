<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operating_area".
 *
 * @property int $area_id รหัสรายการ
 * @property int $zone_id รหัสพื้นที่/กองร้อย
 * @property string $area_name รายการ
 * @property string|null $area_detail รายละเอียด
 * @property string|null $area_remark หมายเหตุ
 * @property string $date_create เวลาบันทึก
 * @property int $user_create ผู้บันทึก
 */
class OperatingArea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operating_area';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_id', 'area_name', 'date_create', 'user_create'], 'required'],
            [['zone_id', 'user_create'], 'integer'],
            [['date_create'], 'safe'],
            [['area_name', 'area_detail', 'area_remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'area_id' => Yii::t('app', 'รหัสรายการ'),
            'zone_id' => Yii::t('app', 'รหัสพื้นที่/กองร้อย'),
            'area_name' => Yii::t('app', 'รายการ'),
            'area_detail' => Yii::t('app', 'รายละเอียด'),
            'area_remark' => Yii::t('app', 'หมายเหตุ'),
            'date_create' => Yii::t('app', 'เวลาบันทึก'),
            'user_create' => Yii::t('app', 'ผู้บันทึก'),
        ];
    }
}
