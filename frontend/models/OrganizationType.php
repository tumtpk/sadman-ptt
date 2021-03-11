<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization_type".
 *
 * @property int $id รหัสประเภทองค์กร
 * @property string $type ประเภทองค์กร
 */
class OrganizationType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','marker_color'], 'required'],
            [['type'], 'string', 'max' => 255],
            [['marker_color'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสประเภทองค์กร'),
            'type' => Yii::t('app', 'ประเภทองค์กร'),
            'marker_color' => Yii::t('app', 'สีประจำประเภท'),
        ];
    }
}
