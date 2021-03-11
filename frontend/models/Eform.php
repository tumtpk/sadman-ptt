<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eform".
 *
 * @property int $id
 * @property int $form_id
 * @property string $form_element
 * @property int $version
 * @property string $detail
 * @property int $active
 * @property int $unit_id
 */
class Eform extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eform';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'form_element', 'version', 'detail', 'active', 'unit_id'], 'required'],
            [['form_id', 'version', 'active', 'unit_id'], 'integer'],
            [['form_element'], 'string', 'max' => 5000],
            [['detail'], 'string', 'max' => 50],
            [['date_create'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'form_element' => 'Form Element',
            'version' => 'Version',
            'detail' => 'Detail',
            'active' => 'Active',
            'unit_id' => 'Unit ID',
            'date_create' => 'Date Create',
        ];
    }
}
