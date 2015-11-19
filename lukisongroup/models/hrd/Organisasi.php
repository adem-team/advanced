<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "c0006".
 *
 * @property integer $id
 * @property integer $parent
 * @property string $title
 * @property string $description
 * @property string $phone
 * @property string $email
 * @property string $image
 * @property integer $itemType
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
use yii\web\UploadedFile;

/**
 * This is the model class for table "c0006".
 *
 * @property string $id
 * @property string $parent
 * @property string $title
 * @property string $description
 * @property string $phone
 * @property string $email
 * @property string $image
 * @property integer $itemType
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
 ///

Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/image/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/image/';

class Organisasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $gambar;
    
    public static function tableName()
    {
        return 'c0006';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','parent'], 'required'],
            ['email','email'],
            [['description'],'match','pattern'=> '/^[A-Za-z0-9_ ]+$/u','message'=> 'only [a-zA-Z0-9_].'],
            [['id', 'parent', 'itemType', 'STATUS'], 'integer'],
            [['UPDATED_TIME'], 'safe'],
            [['title', 'phone', 'email', 'image'], 'string', 'max' => 120],
            [['description'], 'string', 'max' => 300],
            [['gambar'], 'file', 'extensions'=>'jpg, gif, png'],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50]
        ];
    }
     public function getImageFile() 
    {
        return isset($this->image) ? Yii::$app->params['uploadPath'] . $this->image : null;
    }
	
    public function getImageUrl() 
    {
        // return a default image placeholder if your source IMAGE is not found
        $IMAGE = isset($this->image) ? $this->image : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $IMAGE;
    }
	
	public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'gambar');
 
        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }
 
        // store the source file name
        //$this->filename = $image->name;
        $ext = end((explode(".", $image->name)));
 
        // generate a unique file name
        $this->image = 'lukison-'.date('ymdHis').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $image;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'title' => 'Title',
            'description' => 'Description',
            'phone' => 'Phone',
            'email' => 'Email',
            'image' => 'Image',
            'itemType' => 'Item Type',
            'CREATED_BY' => 'Created  By',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
            'STATUS' => 'Status',
        ];
    }
}
