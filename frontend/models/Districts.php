<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "districts".
 *
 * @property string $id
 * @property int $zip_code
 * @property string $name_th
 * @property string $name_en
 * @property int $amphure_id
 */
class Districts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'zip_code', 'name_th', 'name_en'], 'required'],
            [['zip_code', 'amphure_id'], 'integer'],
            [['id'], 'string', 'max' => 6],
            [['name_th', 'name_en'], 'string', 'max' => 150],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'name_th' => Yii::t('app', 'Name Th'),
            'name_en' => Yii::t('app', 'Name En'),
            'amphure_id' => Yii::t('app', 'Amphure ID'),
        ];
    }
}
