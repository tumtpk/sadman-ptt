<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property int $id รหัส
 * @property string $name รายการ
 * @property string $detail รายละเอียด
 * @property string $address ที่อยู่
 * @property string $unit_create หน่วยที่เพิ่มรายการ
 * @property string $user_create ผู้ใช้งานที่เพิ่มรายการ
 * @property string $coor.lat ละติจูด
 * @property string $coor.lon ลองจิจูด
 * @property string $data_json ข้อมูลระดับและตำแหน่ง
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'detail', 'address', 'unit_create', 'user_create', 'coor_lat', 'coor_lon', 'data_json','type','province','district','amphure'], 'required'],
            [['detail', 'address', 'data_json'], 'string'],
            [['type','province','district','amphure'], 'integer'],
            [['village'], 'string', 'max' => 150],
            [['name', 'coor_lat', 'coor_lon'], 'string', 'max' => 255],
            [['unit_create', 'user_create'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัส'),
            'name' => Yii::t('app', 'รายการ'),
            'type' => Yii::t('app', 'ประเภทองค์กร'),
            'detail' => Yii::t('app', 'รายละเอียด'),
            'address' => Yii::t('app', 'บ้านเลขที่'),
            'village' => Yii::t('app', 'หมู่ที่'),
            'district' => Yii::t('app', 'ตำบล'),
            'amphure' => Yii::t('app', 'อำเภอ'),
            'province' => Yii::t('app', 'จังหวัด'),
            'unit_create' => Yii::t('app', 'หน่วยที่เพิ่มรายการ'),
            'user_create' => Yii::t('app', 'ผู้ใช้งานที่เพิ่มรายการ'),
            'coor_lat' => Yii::t('app', 'ละติจูด'),
            'coor_lon' => Yii::t('app', 'ลองจิจูด'),
            'data_json' => Yii::t('app', 'ข้อมูลระดับและตำแหน่ง'),
        ];
    }
}
