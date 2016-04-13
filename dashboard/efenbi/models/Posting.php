<?php

namespace lukisongroup\front\models;
use lukisongroup\front\models\Parents;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "fr002".
 *
 * @property integer $ID
 * @property string $PARENT
 * @property string $JUDUL
 * @property string $RESUME_EN
 * @property string $RESUME_ID
 * @property string $IMG
 * @property string $CREATEBY
 * @property string $UPDATEBY
 */
Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/front';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/front';
class Posting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $image;
    public $file;
    public static function tableName()
    {
        return 'fr002';
    }
    
     public function getParents()
    {
        return $this->hasOne(Parents::className(), ['parent_id' => 'PARENT']);
    }
 
/* Getter for country name */
    public function getParentsName()
     {
        return $this->parents->parent;
     }
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['RESUME_EN', 'RESUME_ID'], 'string'],
            [['CREATEBY', 'UPDATEBY'], 'safe'],
            [['PARENT'], 'string', 'max' => 30],
            [['CHILD'], 'string', 'max' => 11],
            [['GRANDCHILD'], 'string', 'max' => 11],
            [['JUDUL'], 'string', 'max' => 50],
            [['file'],'file'],
            [['IMAGE'], 'string', 'max' => 200],
        //    [['image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }
    
     public function getImageFile() 
    {
        return isset($this->IMAGE) ? Yii::$app->params['uploadPath'] . $this->IMAGE : null;
    }
    
    public function getImageUrl() 
    {
        // return a default image placeholder if your source IMAGE is not found
        $IMAGE = isset($this->IMAGE) ? $this->IMAGE : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $IMAGE;
    }
    
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');
 
        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
//$this->filename = $image->name;
        $ext = end((explode(".", $image->name)));
 
        // generate a unique file name
        $this->IMAGE = 'lukison-'.date('ymdHis').$ext; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $image;
    }
 
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARENT' => 'Parent',
            'CHILD' => 'Child',
            'GRANDCHILD' => 'Grandchild',
            'JUDUL' => 'Judul',
            'RESUME_EN' => 'Resume  En',
            'RESUME_ID' => 'Resume  ID',
            'IMAGE' => 'Image',
            'CREATEBY' => 'Createby',
            'UPDATEBY' => 'Updateby',
            'parentsName' => Yii::t('app', 'Nama Parent'),
        ];
    }

    /**
     * @inheritdoc
     * @return PostingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostingQuery(get_called_class());
    }
}
