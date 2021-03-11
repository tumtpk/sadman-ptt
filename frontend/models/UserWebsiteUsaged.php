<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_website_usaged".
 *
 * @property int $id รหัส
 * @property string $user_id รหัสผู้ใช้งาน
 * @property string $user_name ชื่อนามสกุลผู้ใช้งาน
 * @property string $unit_id รหัสหน่วยงาน
 * @property string $unit_name ชื่อหน่วยงาน
 * @property string $url_website ลิงค์ของเว็บไซต์
 * @property string $create_date วันและเวลาที่ใช้งาน
 * @property string $ip_address IP Address
 */
class UserWebsiteUsaged extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_website_usaged';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'user_name', 'unit_id', 'unit_name', 'url_website', 'create_date', 'ip_address'], 'required'],
            [['url_website'], 'string'],
            [['create_date'], 'safe'],
            [['user_id', 'unit_id'], 'string', 'max' => 20],
            [['user_name', 'unit_name'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'user_id' => 'รหัสผู้ใช้งาน',
            'user_name' => 'ชื่อนามสกุลผู้ใช้งาน',
            'unit_id' => 'รหัสหน่วยงาน',
            'unit_name' => 'ชื่อหน่วยงาน',
            'url_website' => 'ลิงค์ของเว็บไซต์',
            'create_date' => 'วันและเวลาที่ใช้งาน',
            'ip_address' => 'IP Address',
        ];
    }
}
