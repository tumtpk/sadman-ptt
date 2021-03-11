<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_position".
 *
 * @property int $position_id รหัสตำแหน่ง
 * @property string $position_name ชื่อตำแหน่งในองค์กร
 */
class OrganizationPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_name'], 'required'],
            [['position_name'], 'string', 'max' => 255],
            [['user_create'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'position_id' => Yii::t('app', 'รหัสตำแหน่ง'),
            'position_name' => Yii::t('app', 'ชื่อตำแหน่งในองค์กร'),
            'user_create' => Yii::t('app', 'ผู้บันทึกข้อมูล '),
        ];
    }
}
