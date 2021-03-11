<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kptag".
 *
 * @property int $idkp_tag
 * @property string $SP_KP
 * @property string $name_kp
 * @property float $UTM_Indian_N
 * @property float $UTM_Indian_E
 * @property float $UTM_WGS84_N
 * @property float $UTM_WGS84_E
 * @property float $GEO_WGS84_Lat
 * @property float $GEO_WGS84_Long
 * @property float $GEO_WGS84_2_Lat
 * @property float $GEO_WGS84_2_Long
 * @property string|null $remark
 *
 * @property Invasionlist[] $invasionlists
 */
class Kptag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kptag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SP_KP', 'name_kp', 'UTM_Indian_N', 'UTM_Indian_E', 'UTM_WGS84_N', 'UTM_WGS84_E', 'GEO_WGS84_Lat', 'GEO_WGS84_Long', 'GEO_WGS84_2_Lat', 'GEO_WGS84_2_Long'], 'required'],
            [['UTM_Indian_N', 'UTM_Indian_E', 'UTM_WGS84_N', 'UTM_WGS84_E', 'GEO_WGS84_Lat', 'GEO_WGS84_Long', 'GEO_WGS84_2_Lat', 'GEO_WGS84_2_Long'], 'number'],
            [['SP_KP'], 'string', 'max' => 45],
            [['name_kp', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idkp_tag' => 'Idkp Tag',
            'SP_KP' => 'ระยะท่อ',
            'name_kp' => 'ชื่อสถานที่',
            'UTM_Indian_N' => 'Utm Indian N',
            'UTM_Indian_E' => 'Utm Indian E',
            'UTM_WGS84_N' => 'Utm Wgs84 N',
            'UTM_WGS84_E' => 'Utm Wgs84 E',
            'GEO_WGS84_Lat' => 'Geo Wgs84 Latitude',
            'GEO_WGS84_Long' => 'Geo Wgs84 Longitude',
            'GEO_WGS84_2_Lat' => 'Geo Wgs84 2 Latigude',
            'GEO_WGS84_2_Long' => 'Geo Wgs84 2 Longitude',
            'remark' => 'Remark',
        ];
    }

    /**
     * Gets query for [[Invasionlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvasionlists()
    {
        return $this->hasMany(Invasionlist::className(), ['kp_id' => 'idkp_tag']);
    }
}
