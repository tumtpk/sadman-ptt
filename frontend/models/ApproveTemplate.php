<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "approve_template".
 *
 * @property int $id
 * @property string $approve_name
 * @property string $step
 */
class ApproveTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'approve_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['approve_name', 'step'], 'required'],
            [['step'], 'string'],
            [['approve_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'approve_name' => 'การอนุมัติข่าว',
            'step' => 'ขั้นตอนการอนุมัติ',
        ];
    }
}
