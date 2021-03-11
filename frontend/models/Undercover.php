<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;

/**
 * This is the model class for table "undercover".
 *
 * @property int $id รหัส
 * @property string $undercover_number รหัสประจำตัวสายข่าว
 * @property string $name ชื่อสายข่าว
 * @property int $unitid หน่วยงาน
 * @property string $images รูปภาพ
 * @property string $status สถานะการทำงาน
 * @property string $email อีเมล
 * @property string $address ที่อยู่
 * @property string $phone เบอร์โทรศัพท์
 */
class Undercover extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $upload_foler ='uploads';

    public static function tableName()
    {
        return 'undercover';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['undercover_number', 'name', 'unitid', 'images', 'status', 'email', 'address', 'phone'], 'required'],
            [['unitid'], 'integer'],
            [['images', 'address'], 'string'],
            [['undercover_number'], 'string', 'max' => 50],
            [['name', 'email'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 2],
            [['phone'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัส'),
            'undercover_number' => Yii::t('app', 'รหัสประจำตัวสายข่าว'),
            'name' => Yii::t('app', 'ชื่อสายข่าว'),
            'unitid' => Yii::t('app', 'หน่วยงาน'),
            'images' => Yii::t('app', 'รูปภาพ'),
            'status' => Yii::t('app', 'สถานะการทำงาน'),
            'email' => Yii::t('app', 'อีเมล'),
            'address' => Yii::t('app', 'ที่อยู่'),
            'phone' => Yii::t('app', 'เบอร์โทรศัพท์'),
        ];
    }
 public function upload($model,$attribute)
    {
        $photo  = UploadedFile::getInstance($model, $attribute);
        $path = $this->getUploadPath();
        if ($this->validate() && $photo !== null) {

            $fileName = md5($photo->baseName.time()) . '.' . $photo->extension;
            //$fileName = $photo->baseName . '.' . $photo->extension;
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
      return empty($this->images) ? Yii::getAlias('@web').'/img/none.png' : $this->getUploadUrl().$this->images;
  }
}
