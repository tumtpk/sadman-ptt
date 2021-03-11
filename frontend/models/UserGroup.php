<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_group".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class UserGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description','allow_access_main', 'allow_access_sub'], 'required'],
            [['name'], 'string', 'max' => 15],
            [['allow_access_main', 'allow_access_sub'], 'string'],
            [['description'], 'string', 'max' => 35],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'กลุ่มผู้ใช้งาน',
            'description' => 'คำอธิบาย',
            'allow_access_main' => 'การให้สิทธิ์การเข้าถึงเมนูหลัก',
            'allow_access_sub' => 'การให้สิทธิ์การเข้าถึงเมนูย่อย',
        ];
    }
}
