<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $page_name
 * @property string $iframe
 * @property int $status
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_name', 'iframe'], 'required'],
            [['status', 'user_create'], 'integer'],
            [['page_name'], 'string', 'max' => 150],
            [['iframe'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_name' => 'ชื่อ Pages',
            'iframe' => 'Iframe',
            'status' => 'สถานะ',
            'user_create' => 'ผู้บันทึก',
        ];
    }
}
