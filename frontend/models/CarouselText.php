<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;
/**
 * This is the model class for table "carousel_text".
 *
 * @property int $id
 * @property string $name
 * @property string $detail
 * @property string $images
 * @property int $slot
 * @property string $create_time
 */
class CarouselText extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public $upload_foler ='uploads';
    public static function tableName()
    {
        return 'carousel_text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'detail'], 'required'],
            [['images'], 'string'],
            [['user_create'], 'integer'],
            [['slot'],  'string', 'max' => 11],
            [['create_time'], 'safe'],
            [['name', 'detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'name' => 'รายการ',
            'detail' => 'รายละเอียด',
            'images' => 'รูปภาพ',
            'slot' => 'ลำดับการแสดง',
            'create_time' => 'เวลาบันทึก',
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
      return empty($this->images) ? Yii::getAlias('@web').'/img/none.png' : $this->getUploadUrl().$this->images;
  }
}
