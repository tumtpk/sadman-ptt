<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webboard_topic".
 *
 * @property int $topic_id รหัสหัวข้อเรื่อง
 * @property string $topic_name ชื่อหัวข้อเรื่อง
 * @property string $topic_detail รายละเอียดจากหัวข้อ
 * @property string $topic_view จำนวนผู้เข้าดู
 * @property string $topic_reply จำนวนคนคอมเม้นต์
 * @property string $topic_date_create วันที่บันทึก
 * @property string $topic_user_create ผู้บันทึก
 * @property string $forum_id รหัสหมวดหมู่
 * @property string $status_del สถานะยกเลิกความคิดเห็น	
 * @property string $key_images_or_file รหัสเชื่อมโยงรูปภาพ
 */
class WebboardTopic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webboard_topic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_name', 'topic_detail', 'topic_date_create', 'topic_user_create', 'forum_id', 'status_del', 'key_images_or_file'], 'required'],
            [['topic_detail'], 'string'],
            [['topic_name'], 'string', 'max' => 255],
            [['topic_view', 'topic_reply', 'topic_user_create'], 'string', 'max' => 7],
            [['topic_date_create', 'key_images_or_file'], 'string', 'max' => 20],
            [['forum_id'], 'string', 'max' => 10],
            [['status_del'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'topic_id' => 'รหัสหัวข้อเรื่อง',
            'topic_name' => 'ชื่อหัวข้อเรื่อง',
            'topic_detail' => 'รายละเอียดจากหัวข้อ',
            'topic_view' => 'จำนวนผู้เข้าดู',
            'topic_reply' => 'จำนวนคนคอมเม้นต์',
            'topic_date_create' => 'วันที่บันทึก/แก้ไข',
            'topic_user_create' => 'ผู้บันทึก',
            'forum_id' => 'รหัสหมวดหมู่',
            'status_del' => 'สถานะยกเลิกกระทู้ข่าว',
            'key_images_or_file' => 'รหัสเชื่อมโยงรูปภาพ',
        ];
    }
}
