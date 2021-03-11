<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news_values".
 *
 * @property int $id
 * @property string $news_val_name
 * @property string $news_val_detail
 * @property string $user_create_update
 */
class NewsValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_val_name', 'news_val_detail', 'user_create_update'], 'required'],
            [['news_val_name'], 'string', 'max' => 100],
            [['news_val_detail'], 'string', 'max' => 255],
            [['user_create_update'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_val_name' => 'ค่าของข่าว',
            'news_val_detail' => 'รายละเอียด',
            'user_create_update' => 'ผู้ที่บันทึก/แก้ไข',
        ];
    }
}
