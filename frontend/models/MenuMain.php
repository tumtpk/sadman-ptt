<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%menu_main}}".
 *
 * @property int $id รหัสเมนูหลัก
 * @property string $m_name ชื่อเมนูหลัก
 * @property string $m_link ลิงค์เชื่อมโยง
 * @property string $m_role สิทธิ์การเข้าใช้งาน
 * @property string $m_status สถานะเมนูหลัก
 */
class MenuMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_main}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['m_name', 'm_status', 'm_icon'], 'required'],
            [['m_link'], 'string'],
            [['m_name', 'm_role','m_detail'], 'string', 'max' => 255],
            [['m_icon','m_type'], 'string', 'max' => 50],
            [['m_status'], 'string', 'max' => 1],
            [['m_active','m_sort'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสเมนูหลัก',
            'm_name' => 'ชื่อเมนูหลัก',
            'm_link' => 'ลิงค์เชื่อมโยง',
            'm_role' => 'สิทธิ์การเข้าใช้งาน',
            'm_status' => 'สถานะเมนูหลัก',
            'm_active' => 'เน้นเมนู',
            'm_icon' => 'ไอคอน',
            'm_type' => 'รูปแบบเมนู',
            'm_detail' => 'รายละเอียดเมนู',
        ];
    }
}
