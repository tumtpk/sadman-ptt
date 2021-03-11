<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%menu_sub}}".
 *
 * @property int $submenu_id
 * @property string $submenu_name
 * @property string $submenu_role
 * @property string $submenu_link
 * @property string $submenu_active
 * @property int $menu_id
 */
class MenuSub extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%menu_sub}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['submenu_name', 'submenu_link', 'submenu_active', 'menu_id'], 'required'],
            [['submenu_name', 'submenu_link', 'submenu_active'], 'string'],
            [['menu_id','submenu_sort'], 'integer'],
            [['s_detail'], 'string', 'max' => 255],
            [['s_icon'], 'string', 'max' => 50],
            [['submenu_role'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'submenu_id' => 'Submenu ID',
            'submenu_name' => 'เมนูย่อย',
            'submenu_role' => 'สิทธิ์ผู้เข้าใช้งาน',
            'submenu_link' => 'ลิงค์',
            'submenu_active' => 'สถานะเมนู',
            's_icon' => 'ไอคอน',
            'menu_id' => 'เมนูหลัก',
            's_detail' => 'รายละเอียดเมนู',
        ];
    }
}
