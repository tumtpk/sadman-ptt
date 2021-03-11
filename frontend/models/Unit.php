<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $unit_id
 * @property string $unit_name
 * @property string $unit_detail
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_name', 'unit_detail','admin_limit','user_limit','undercover_limit'], 'required'],
            [['unit_name'], 'string', 'max' => 255],
            [['unit_detail'], 'string', 'max' => 500],
            [['address'], 'string', 'max' => 400],
            [['province'], 'string', 'max' => 50],
            [['lat','lon'], 'string', 'max' => 15],
            [['create_by'], 'string', 'max' => 4],
            [['have_active','admin_limit','user_limit','undercover_limit'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'ID',
            'unit_name' => 'ชื่อหน่วยงาน',
            'unit_detail' => 'รายละเอียด',
            'have_active' => 'ผู้ดูแลระบบของหน่วยงาน',
            'address'=>'ที่อยู่',
            'province'=>'จังหวัด',
            'lat'=>'ละติจูด',
            'lon'=>'ลองจิจูด',
            'admin_limit'=>'จำกัดจำนวนผู้ดูแล',
            'user_limit'=>'จำกัดจำนวนผู้ใช้งาน',
            'undercover_limit'=>'จำกัดจำนวนสายข่าว',
        ];
    }
}
