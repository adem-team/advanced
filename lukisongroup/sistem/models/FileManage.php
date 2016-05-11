<?php

namespace lukisongroup\sistem\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "file_manage".
 *
 * @property string $ID
 * @property string $USER_ID
 * @property string $GROUP
 * @property string $FILE_PATH
 * @property string $FILE_NM
 * @property string $FILE_NM64
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
 
Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/';

class FileManage extends \yii\db\ActiveRecord
{
	
	public $uploadDataFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_manage';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FILE_NM64'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['USER_ID', 'GROUP', 'CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['FILE_PATH', 'FILE_NM'], 'string', 'max' => 255],
			//[['uploadDataFile'], 'file', 'extensions'=>'xls, xlsx,png,jpg'],
			[['uploadDataFile'], 'file', 'extensions'=>'png,jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('app', 'ID'),
            'USER_ID' => Yii::t('app', 'User  ID'),
            'GROUP' => Yii::t('app', 'Group'),
            'FILE_PATH' => Yii::t('app', 'FOLDER PATH'),
            'FILE_NM' => Yii::t('app', 'FILE NAME'),
            'FILE_NM64' => Yii::t('app', 'FILE DECODE TO BASE 64'),
            'STATUS' => Yii::t('app', 'Status'),
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
        ];
    }
	
	public function getImageFile()
    {
        return isset($this->FILE_NM) ? Yii::$app->params['uploadPath'] .$this->FILE_PATH.'/'. $this->FILE_NM : null;
    }

    public function getImageUrl()
    {
        // return a default image placeholder if your source IMAGE is not found
        $FILE_NM = isset($this->FILE_NM) ? $this->FILE_NM : 'default_import_sales.xlsx';
        return Yii::$app->params['uploadUrl'] .$this->FILE_PATH.'/'. $FILE_NM;
    }

	public function uploadFile() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
       // $uploadData = UploadedFile::getInstance($this, 'uploadDataFile');
		$uploadData = UploadedFile::getInstance($this, 'uploadDataFile');

        // if no image was uploaded abort the upload
        if (empty($uploadData)) {
            return false;
        }

        // store the source file name
        //$this->filename = $image->name;
        $ext = end((explode(".", $uploadData->name)));

        // generate a unique file name
        $this->FILE_NM = 'signature-'.date('Y-m-d-His').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $uploadData;
    }
}
