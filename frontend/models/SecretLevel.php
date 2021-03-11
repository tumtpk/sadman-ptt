<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "secret_level".
 *
 * @property int $id
 * @property string $level
 * @property string $description
 * @property int $status
 */
class SecretLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'secret_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'description'], 'required'],
            [['status'], 'integer'],
            [['level'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'level' => Yii::t('app', 'แหล่งข้อมูล (Model)'),
            'description' => Yii::t('app', 'คำอธิบาย'),
            'status' => Yii::t('app', 'สถานะ'),
        ];
    }
}
