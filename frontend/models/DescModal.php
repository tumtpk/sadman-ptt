<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "desc_modal".
 *
 * @property int $id
 * @property string $topic
 * @property string $description
 * @property int $status
 */
class DescModal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desc_modal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic', 'description', 'status'], 'required'],
            [['status', 'user_create'], 'integer'],
            [['topic'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic' => 'หัวข้อ',
            'description' => 'คำอธิบาย',
            'status' => 'สถานะการใช้งาน (เปิด/ปิด)',
            'user_create' => 'ผู้บันทึก',
        ];
    }
}
