<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webboard_answer_reply".
 *
 * @property int $answer_reply_id รหัสคอมเม้นต์
 * @property string $answer_reply_detail รายละเอียดความคิดเห็น
 * @property string $answer_reply_date_create วันที่บันทึก
 * @property int $answer_reply_user_create ผู้บันทึก
 * @property string $answer_id รหัสคอมเมนต์
 * @property string $topic_id รหัสหัวข้อเรื่อง
 * @property string $status_del สถานะยกเลิกความคิดเห็น
 * @property string $key_images_or_file รหัสเชื่อมโยงรูปภาพ	
 */
class WebboardAnswerReply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webboard_answer_reply';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer_reply_detail', 'answer_reply_date_create', 'answer_reply_user_create', 'answer_id', 'topic_id', 'status_del', 'key_images_or_file'], 'required'],
            [['answer_reply_detail'], 'string'],
            [['answer_reply_user_create'], 'integer'],
            [['answer_reply_date_create', 'key_images_or_file'], 'string', 'max' => 20],
            [['answer_id'], 'string', 'max' => 11],
            [['topic_id'], 'string', 'max' => 10],
            [['status_del'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'answer_reply_id' => 'รหัสคอมเม้นต์',
            'answer_reply_detail' => 'รายละเอียดความคิดเห็น',
            'answer_reply_date_create' => 'วันที่บันทึก',
            'answer_reply_user_create' => 'ผู้บันทึก',
            'answer_id' => 'รหัสคอมเมนต์',
            'topic_id' => 'รหัสหัวข้อเรื่อง',
            'status_del' => 'สถานะยกเลิกความคิดเห็น',
            'key_images_or_file' => 'รหัสเชื่อมโยงรูปภาพ	',
        ];
    }
}
