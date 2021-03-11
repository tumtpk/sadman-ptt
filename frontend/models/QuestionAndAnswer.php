<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "question_and_answer".
 *
 * @property int $qa_id
 * @property string|null $qa_questions
 * @property string|null $qa_answer
 * @property string|null $qa_date_create
 * @property int|null $qa_status
 * @property int|null $qa_slot
 */
class QuestionAndAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question_and_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qa_questions', 'qa_answer'], 'string'],
            [['qa_date_create'], 'safe'],
            [['qa_status', 'qa_slot', 'user_create'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'qa_id' => 'รหัส',
            'qa_questions' => 'คำถาม',
            'qa_answer' => 'คำตอบ',
            'qa_date_create' => 'วันที่บันทึก',
            'qa_status' => 'สถานะ',
            'qa_slot' => 'ลำดับ',
            'user_create' => 'ผู้บันทึก',
        ];
    }
}
