<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webboard_forum".
 *
 * @property int $forum_id รหัสหมวดหมู่
 * @property string $forum_name ชื่อหมวดหมู่
 * @property string $forum_date_create วันที่บันทึก
 * @property string $forum_user_create ผู้บันทึก
 */
class WebboardForum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webboard_forum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['forum_name', 'forum_date_create', 'forum_user_create'], 'required'],
            [['forum_name'], 'string', 'max' => 255],
            [['forum_date_create'], 'string', 'max' => 20],
            [['forum_user_create'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'forum_id' => 'รหัสหมวดหมู่',
            'forum_name' => 'ชื่อหมวดหมู่',
            'forum_date_create' => 'วันที่บันทึก',
            'forum_user_create' => 'ผู้บันทึก',
        ];
    }
}
