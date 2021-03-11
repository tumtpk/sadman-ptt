<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eform_header".
 *
 * @property int $id
 * @property int $form_id
 * @property string $form_header Header
 * @property string $form_footer Footer
 */
class EformHeader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'eform_header';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'form_header', 'form_footer'], 'required'],
            [['form_id'], 'integer'],
            [['form_header', 'form_footer'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'form_id' => Yii::t('app', 'Form ID'),
            'form_header' => Yii::t('app', 'Header'),
            'form_footer' => Yii::t('app', 'Footer'),
        ];
    }
}
