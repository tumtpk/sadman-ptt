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
 * @property string $images
 * @property int $status
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $upload_foler ='uploads';

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'username', 'password', 'role', 'status'], 'required'],
            //'auth_key', 'password_reset_token', 'images'
            [['username'], 'unique',
            'targetClass' => Users::className(),
            'message' => 'This username is already taken'],
            [['role', 'status'], 'integer'],
            // [['images'], 'string'],
            [['images'], 'file',
              'skipOnEmpty' => true,
              'extensions' => 'png,jpg'
            ],
            [['name', 'password_reset_token'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 30],
            [['password'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
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
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'role' => 'Role',
            'images' => 'Images',
            'status' => 'Status',
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
