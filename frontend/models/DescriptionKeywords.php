<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;

/**
 * This is the model class for table "description_keywords".
 *
 * @property int $id รหัสคำธิบายการใช้งาน
 * @property string $name หัวเรื่องคำอธิบาย
 * @property string $detail คำอธิบายการใช้งาน
 * @property string $images รูปภาพ
 */
class DescriptionKeywords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $upload_foler ='../../images_keywords';
    public static function tableName()
    {
        return 'description_keywords';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'detail'], 'required'],
            [['user_create'], 'integer'],
            [['name', 'detail'], 'string', 'max' => 255],
            [['images'], 'file',
            'skipOnEmpty' => true,
            'extensions' => 'png,jpg,jpeg'
        ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสคำธิบายการใช้งาน',
            'name' => 'หัวเรื่องคำอธิบาย',
            'detail' => 'คำอธิบายการใช้งาน',
            'images' => 'รูปภาพ',
            'user_create' => 'ผู้บันทึก',
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
      return empty($this->images) ? Yii::getAlias('@web').'/'.$this->upload_foler.'/none.png' : $this->getUploadUrl().$this->images;
  } 
}
