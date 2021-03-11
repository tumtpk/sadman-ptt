<?php

namespace app\models;

use Yii;
use \yii\web\UploadedFile;

/**
 * This is the model class for table "eform_template".
 *
 * @property int $id
 * @property int $type
 * @property string $form_element
 * @property int $version
 * @property string $detail
 */
class EformTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $upload_foler ='../../images/template_files';
    public static function tableName()
    {
        return 'eform_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'form_element', 'version', 'detail'], 'required'],//,'unit_id'
            [['type', 'version','disable'], 'integer'],
            [['form_element','unit_id','dashboard_link','dashboard_header_link','guide_report_record'], 'string', 'max' => 5000],
            [['approve_type'], 'string', 'max' => 2],
            [['detail'], 'string', 'max' => 50],
            [['mapping'], 'string', 'max' => 500],
            [['header_record','footer_record','header_all','footer_all'], 'string', 'max' => 5500],
            [['images'], 'file',
            'skipOnEmpty' => true,
            'extensions' => 'png,jpg,jpeg'
            ],
            [['position_images'], 'string', 'max' => 1],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'ประเภท Eform',
            'form_element' => 'Form Element',
            'version' => 'Version',
            'detail' => 'รายละเอียด',
            'mapping'=> 'mapping',
            'disable'=> 'เปิด/ปิด ใช้งาน',
            'unit_id'=> 'หน่วยงานที่สามารถใช้งาน',
            'approve_type'=>'ประเภทการอนุมัติข่าว',
            'dashboard_link'=>'Link สำหรับหน้า Dashboard',
            'dashboard_header_link'=>'Link สำหรับหน้า Dashboard แบบย่อ',
            'guide_report_record'=>'ออกแบบหน้ารายงานแบบรายการเดียว',
            'header_record'=>'หัวกระดาษรายงาน [ข้อมูลรายการเดียว]',
            'footer_record'=>'ท้ายกระดาษรายงาน [ข้อมูลรายการเดียว]',
            'header_all'=>'หัวกระดาษรายงาน [ข้อมูลรายการรวม]',
            'images' => 'รูปภาพ',
            'position_images' => 'ตำแหน่งการแสดงรูปภาพ',
            'footer_all'=>'ท้ายกระดาษรายงาน [ข้อมูลรายการรวม]'
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