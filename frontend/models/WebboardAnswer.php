<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "webboard_answer".
 *
 * @property int $answer_id รหัสคอมเม้นต์
 * @property string $answer_detail รายละเอียดความคิดเห็น
 * @property string $answer_date_create วันที่บันทึก
 * @property int $answer_user_create ผู้บันทึก
 * @property string $topic_id รหัสหัวข้อเรื่อง
 * @property string $status_del สถานะยกเลิกความคิดเห็น
 * @property string $key_images_or_file รหัสเชื่อมโยงรูปภาพ	
 */
class WebboardAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webboard_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer_detail', 'answer_date_create', 'answer_user_create', 'topic_id', 'status_del', 'key_images_or_file'], 'required'],
            [['answer_detail'], 'string'],
            [['answer_user_create'], 'integer'],
            [['answer_date_create', 'key_images_or_file'], 'string', 'max' => 20],
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
            'answer_id' => 'รหัสคอมเม้นต์',
            'answer_detail' => 'รายละเอียดความคิดเห็น',
            'answer_date_create' => 'วันที่บันทึก',
            'answer_user_create' => 'ผู้บันทึก',
            'topic_id' => 'รหัสหัวข้อเรื่อง',
            'status_del' => 'สถานะยกเลิกความคิดเห็น',
            'key_images_or_file' => 'รหัสเชื่อมโยงรูปภาพ	',
        ];
    }
}
