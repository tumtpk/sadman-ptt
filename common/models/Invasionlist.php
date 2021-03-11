<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invasionlist".
 *
 * @property int $idinvasionlist
 * @property string $detail
 * @property int $kp_id
 * @property int $severity
 * @property int $procedure_id
 * @property string|null $inspection_result_TMM
 * @property string $date
 *
 * @property Kptag $kp
 * @property Procedure $procedure
 * @property Severity $severity0
 */
class Invasionlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invasionlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail', 'kp_id', 'severity', 'procedure_id', 'date'], 'required'],
            [['kp_id', 'severity', 'procedure_id'], 'integer'],
            [['date'], 'safe'],
            [['detail', 'inspection_result_TMM'], 'string', 'max' => 255],
            [['kp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kptag::className(), 'targetAttribute' => ['kp_id' => 'idkp_tag']],
            [['procedure_id'], 'exist', 'skipOnError' => true, 'targetClass' => Procedure::className(), 'targetAttribute' => ['procedure_id' => 'idprocedure']],
            [['severity'], 'exist', 'skipOnError' => true, 'targetClass' => Severity::className(), 'targetAttribute' => ['severity' => 'idseverity']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idinvasionlist' => 'Idinvasionlist',
            'detail' => 'รายละเอียด',
            'kp_id' => 'ระยะท่อ',
            'severity' => 'ความรุนแรง',
            'procedure_id' => 'ขั้นตอน',
            'inspection_result_TMM' => 'ผลการตรวจสอบโดย TTM และ ปท.7',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Kp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKp()
    {
        return $this->hasOne(Kptag::className(), ['idkp_tag' => 'kp_id']);
    }

    /**
     * Gets query for [[Procedure]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProcedure()
    {
        return $this->hasOne(Procedure::className(), ['idprocedure' => 'procedure_id']);
    }

    /**
     * Gets query for [[Severity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeverity0()
    {
        return $this->hasOne(Severity::className(), ['idseverity' => 'severity']);
    }
}
