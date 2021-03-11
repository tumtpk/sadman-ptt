<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_role}}".
 *
 * @property int $id
 * @property string $role
 * @property string $allow_access_main การให้สิทธิ์การเข้าถึงเมนูหลัก
 * @property string $allow_access_sub การให้สิทธิ์การเข้าถึงเมนูย่อย
 */
class UserRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'allow_access_main', 'allow_access_sub'], 'required'],
            [['allow_access_main', 'allow_access_sub'], 'string'],
            [['role'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'allow_access_main' => 'การให้สิทธิ์การเข้าถึงเมนูหลัก',
            'allow_access_sub' => 'การให้สิทธิ์การเข้าถึงเมนูย่อย',
        ];
    }
}
