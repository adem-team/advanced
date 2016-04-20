<?php

namespace crm\salesman\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "so_t2_file_user".
 *
 * @property string $ID
 * @property string $USER_ID
 * @property string $FILE_PATH
 * @property string $FILE_NM
 * @property integer $STATUS
 */
 Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/sales_import/';
 Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/sales_import/';
class UserFile extends \yii\db\ActiveRecord
{

	public $uploadExport;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'so_t2_file_user';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['ID'], 'required'],
            [['ID', 'STATUS'], 'integer'],
            [['USER_ID'], 'string', 'max' => 50],
            [['FILE_PATH', 'FILE_NM'], 'string', 'max' => 255],
            //[['FILE_PATH'], 'string', 'max' => 255],
			[['uploadExport'], 'file', 'extensions'=>'xls, xlsx'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'USER_ID' => 'User  ID',
            'FILE_PATH' => 'File  Path',
            'FILE_NM' => 'File  Nm',
            'STATUS' => 'Status',
        ];
    }

	public function getImageFile()
    {
        return isset($this->FILE_NM) ? Yii::$app->params['uploadPath'] . $this->FILE_NM : null;
    }

    public function getImageUrl()
    {
        // return a default image placeholder if your source IMAGE is not found
        $FILE_NM = isset($this->FILE_NM) ? $this->FILE_NM : 'default_import_sales.xlsx';
        return Yii::$app->params['uploadUrl'] . $FILE_NM;
    }

	public function uploadFile() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $uploadData = UploadedFile::getInstance($this, 'uploadExport');

        // if no image was uploaded abort the upload
        if (empty($uploadData)) {
            return false;
        }

        // store the source file name
        //$this->filename = $image->name;
        $ext = end((explode(".", $uploadData->name)));

        // generate a unique file name
        $this->FILE_NM = 'stock-'.date('Y-m-d-His').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $uploadData;
    }





}
