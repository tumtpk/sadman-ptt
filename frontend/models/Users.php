<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;
/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $password_reset_token
 * @property int $role
 * @property string $user_group
 * @property string $images
 * @property int $status
 * @property string $email อีเมล์
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $upload_foler ='uploads';
    
    public static function tableName()
    {
        return '{{%users%}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'username', 'password', 'role', 'status', 'email','unit_id','notification'], 'required'],
            [['role', 'status', 'notification'], 'integer'],
            [['images'], 'string'],
            [['name', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 30],
            [['username'], 'unique',
            'targetClass' => Users::className(),
            'message' => 'username : ถูกนำไปใช้งานแล้ว กรุณากรอกใหม่'],
            [['email'], 'unique',
            'targetClass' => Users::className(),
            'message' => 'อีเมล : ถูกนำไปใช้งานแล้ว กรุณากรอกใหม่'],
            [['password'], 'string', 'min' => 8],
            [['auth_key'], 'string', 'max' => 32],
            [['unit_id'], 'string', 'max' => 4],
            [['user_group'], 'string', 'max' => 2],
            [['font_size'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'name' => 'ชื่อ-นามสกุล',
            'username' => 'ชื่อผู้ใช้',
            'password' => 'รหัสผ่าน',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'role' => 'Role',
            'user_group' => 'กลุ่มผู้ใช้',
            'images' => 'รูปภาพ',
            'status' => 'สถานะ',
            'email' => 'อีเมล์',
            'unit_id' => 'หน่วยงาน',
            'notification' => 'สถานะการแจ้งเตือน',
            'font_size' => 'ขนาดตัวอักษร',
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
