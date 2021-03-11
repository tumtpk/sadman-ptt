<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operating_main".
 *
 * @property int $id รหัสรายการ
 * @property int $zone_id รหัสโซน
 * @property int $area_id รหัสพื้นที่/กองร้อย
 * @property string $name รายการ
 * @property string|null $detail รายละเอียด
 * @property string|null $remark หมายเหตุ
 * @property string $date_create วันที่บันทึก
 * @property int $user_create ผู้บันทึก
 */
class OperatingMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operating_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zone_id', 'area_id', 'province', 'amphure', 'district', 'organization_id', 'name', 'date_create', 'user_create'], 'required'],
            [['zone_id', 'area_id', 'province', 'amphure','district', 'organization_id', 'user_create'], 'integer'],
            [['date_create'], 'safe'],
            [['name', 'remark'], 'string', 'max' => 255],
            [['detail'], 'string', 'max' => 5500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสรายการ'),
            'zone_id' => Yii::t('app', 'รหัสโซน'),
            'area_id' => Yii::t('app', 'รหัสพื้นที่/กองร้อย'),
            'province' => Yii::t('app', 'รหัสจังหวัด'),
            'amphure' => Yii::t('app', 'รหัสอำเภอ'),
            'district' => Yii::t('app', 'รหัสตำบล'),
            'organization_id' => Yii::t('app', 'องค์กรที่รับผิดชอบ'),
            'name' => Yii::t('app', 'รายการ'),
            'detail' => Yii::t('app', 'รายละเอียด'),
            'remark' => Yii::t('app', 'หมายเหตุ'),
            'date_create' => Yii::t('app', 'วันที่บันทึก'),
            'user_create' => Yii::t('app', 'ผู้บันทึก'),
        ];
    }
}
