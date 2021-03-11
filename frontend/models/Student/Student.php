<?php

namespace app\models\Student;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $name
 * @property int $gender
 * @property string $address
 * @property string $tel
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'gender', 'address', 'tel'], 'required'],
            [['gender'], 'integer'],
            [['name', 'address'], 'string', 'max' => 50],
            [['tel'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'gender' => 'Gender',
            'address' => 'Address',
            'tel' => 'Tel',
        ];
    }
}
