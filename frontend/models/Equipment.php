<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment".
 *
 * @property int $id รหัสรายการ
 * @property string $name รายการ
 * @property int $type ประเภท
 * @property string $brand ยี่ห้อ
 * @property string $model รุ่น
 * @property string $detail รายละเอียด
 * @property int $status สถานะ
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'brand', 'model','pronoun'], 'required'],
            [['type', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['brand', 'model'], 'string', 'max' => 70],
            [['pronoun'], 'string', 'max' => 20],
            [['detail'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสรายการ'),
            'name' => Yii::t('app', 'รายการ'),
            'type' => Yii::t('app', 'ประเภท'),
            'brand' => Yii::t('app', 'ยี่ห้อ'),
            'model' => Yii::t('app', 'รุ่น'),
            'pronoun' => Yii::t('app', 'หน่วยนับ'),
            'detail' => Yii::t('app', 'รายละเอียด'),
            'status' => Yii::t('app', 'สถานะ'),
        ];
    }
}
