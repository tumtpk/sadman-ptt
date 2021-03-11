<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_upload_list".
 *
 * @property int $id
 * @property string $bucket
 * @property string $file_name
 * @property string $text_extract ข้อความ
 * @property string $form_id แหล่งข้อมูล
 * @property int $status สถานะ
 */
class FileUploadList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_upload_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bucket', 'file_name', 'text_extract'], 'required'],
            [['text_extract','origin_file_name'], 'string'],
            [['status'], 'integer'],
            [['bucket'], 'string', 'max' => 60],
            [['file_name'], 'string', 'max' => 150],
            [['form_id'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bucket' => 'Bucket',
            'file_name' => 'ชื่อไฟล์',
            'origin_file_name' => 'ชื่อไฟล์ต้นฉบับ',
            'text_extract' => 'ข้อความ',
            'form_id' => 'แหล่งข้อมูล',
            'status' => 'สถานะ',
            'status_upload' => 'แหล่งที่อัพโหลดไฟล์',
        ];
    }
}
