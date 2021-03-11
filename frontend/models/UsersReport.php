<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;
/**
 * This is the model class for table "users_report".
 *
 * @property int $id รหัสรายงานส่วนบุคคล
 * @property string $data_json รูปแบบรายงานส่วนบุคคล
 * @property string $user_create ผู้บันทึกข้อมูล
 * @property string $date_record วันที่บันทึก/แก้ไข
 */
class UsersReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $upload_foler ='../../images/logo_users_report';
    public static function tableName()
    {
        return 'users_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_json', 'user_create', 'date_record','header_report','footer_report','position_logo'], 'required'],
            [['data_json'], 'string'],
            [['logo_report'], 'file',
            'skipOnEmpty' => true,
            'extensions' => 'png,jpg,jpeg'
            ],
            [['user_create'], 'string', 'max' => 3],
            [['position_logo'], 'string', 'max' => 1],
            [['header_report','footer_report'], 'string', 'max' => 5500],
            [['date_record'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสรายงานส่วนบุคคล'),
            'data_json' => Yii::t('app', 'รูปแบบรายงานส่วนบุคคล'),
            'user_create' => Yii::t('app', 'ผู้บันทึกข้อมูล'),
            'date_record' => Yii::t('app', 'วันที่บันทึก/แก้ไข'),
            'header_report' => Yii::t('app', 'หัวกระดาษรายงาน'),
            'footer_report' => Yii::t('app', 'ท้ายกระดาษรายงาน'),
            'position_logo' => Yii::t('app', 'ตำแหน่งของโลโก้'),
            'logo_report' => Yii::t('app', 'ท้ายกระดาษรายงาน'),
        ];
    }

    public function upload($model,$attribute)
    {
        $photo  = UploadedFile::getInstance($model, $attribute);
        $path = $this->getUploadPath();
        if ($this->validate() && $photo !== null) {

            $fileName = md5($photo->baseName.time()) . '.' . $photo->extension;
            if($photo->saveAs($path.$fileName)){
              return $fileName;
          }
      }
      return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
  }

  public function getUploadPath(){
      return Yii::getAlias('@webroot').'/'.$this->upload_foler.'/';
  }

  public function getUploadUrl(){
      return Yii::getAlias('@web').'/'.$this->upload_foler.'/';
  }

  public function getPhotoViewer(){
      return empty($this->logo_report) ? Yii::getAlias('@web').'/'.$this->upload_foler.'/none.png' : $this->getUploadUrl().$this->logo_report;
  }
}
