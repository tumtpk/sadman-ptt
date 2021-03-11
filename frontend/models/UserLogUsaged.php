<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_log_usaged".
 *
 * @property int $log_id รหัส
 * @property string|null $username ชื่อผู้ใช้[user_id]
 * @property string $user ชื่อนามสกุลผู้ใช้งาน
 * @property string $unit ชื่อหน่วยงาน
 * @property string|null $log_date วันที่ เวลา login เข้าใช้งานระบบ
 * @property string|null $create_date วันที่สร้างรายการข้อมูล
 * @property string|null $status สถานะรายการ 1: รายการปกติ 0: รายการถูกยกเลิก
 * @property string $ip_address IP Address
 * @property string|null $remark หมายเหตุการทำรายการ
 */
class UserLogUsaged extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_log_usaged';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'unit', 'ip_address'], 'required'],
            [['log_date', 'create_date'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['user', 'unit'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
            [['ip_address'], 'string', 'max' => 30],
            [['remark'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_id' => 'รหัส',
            'username' => 'ชื่อผู้ใช้[user_id]',
            'user' => 'ชื่อนามสกุลผู้ใช้งาน',
            'unit' => 'ชื่อหน่วยงาน',
            'log_date' => 'วันที่ เวลา login เข้าใช้งานระบบ',
            'create_date' => 'วันที่สร้างรายการข้อมูล',
            'status' => 'สถานะรายการ 1: รายการปกติ 0: รายการถูกยกเลิก',
            'ip_address' => 'IP Address',
            'remark' => 'หมายเหตุการทำรายการ',
        ];
    }
}
