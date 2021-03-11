<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_type".
 *
 * @property int $id รหัสประเภท
 * @property string $name รายการ
 * @property string $detail รายละเอียด
 */
class EquipmentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'detail'], 'required'],
            [['name', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสประเภท'),
            'name' => Yii::t('app', 'รายการ'),
            'detail' => Yii::t('app', 'รายละเอียด'),
        ];
    }
}
