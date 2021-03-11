<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eform_template_type".
 *
 * @property int $id
 * @property string $type
 * @property string $description
 */
class EformTemplateType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eform_template_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'description'], 'required'],
            [['type'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 35],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'description' => 'Description',
        ];
    }
}
