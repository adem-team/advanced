<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "u0006m".
 *
 * @property integer $ID
 * @property string $JOBSDESK_TITLE
 * @property string $JOBGRADE_NM
 * @property string $JOBGRADE_DCRP
 * @property integer $JOBGRADE_STS
 * @property string $JOBSDESK_IMG
 * @property string $JOBSDESK_PATH
 * @property integer $SORT
 * @property string $CORP_ID
 * @property string $DEP_ID
 * @property string $DEP_SUB_ID
 * @property integer $GF_ID
 * @property integer $SEQ_ID
 * @property string $JOBGRADE_ID
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
 Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/image/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/image/';
class Jobdesc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 public $image;
    public static function tableName()
    {
        return 'u0006m';
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
			[['SEQ_ID','GF_ID','JOBGRADE_ID','DEP_SUB_ID','DEP_ID','CORP_ID','JOBGRADE_NM','JOBGRADE_STS', 'SORT','JOBSDESK_TITLE'], 'required'],
            [['JOBGRADE_DCRP'], 'string'],
            [['JOBGRADE_STS', 'SORT', 'GF_ID', 'SEQ_ID', 'STATUS'], 'integer'],
            [['UPDATED_TIME'], 'safe'],
            [['JOBSDESK_TITLE'], 'string', 'max' => 255],
            [['JOBGRADE_NM', 'JOBSDESK_IMG', 'JOBSDESK_PATH'], 'string', 'max' => 100],
            [['CORP_ID'], 'string', 'max' => 5],
            [['DEP_ID', 'DEP_SUB_ID', 'JOBGRADE_ID'], 'string', 'max' => 6],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50],
			   [['image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }
	
	 public function getImageFile() 
    {
        return isset($this->JOBSDESK_IMG) ? Yii::$app->params['uploadPath'] . $this->JOBSDESK_IMG : null;
    }
	
    public function getImageUrl() 
    {
        // return a default image placeholder if your source IMAGE is not found
        $IMAGE = isset($this->JOBSDESK_IMG) ? $this->JOBSDESK_IMG : 'default_user.jpg';
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
        $this->JOBSDESK_IMG = 'lukison-'.date('ymdHis').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";
 
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
            'JOBSDESK_TITLE' => 'Jobsdesk  Title',
            'JOBGRADE_NM' => 'Jobgrade  Nm',
            'JOBGRADE_DCRP' => 'Jobgrade  Dcrp',
            'JOBGRADE_STS' => 'Jobgrade  Sts',
            'JOBSDESK_IMG' => 'Jobsdesk  Img',
            'JOBSDESK_PATH' => 'Jobsdesk  Path',
            'SORT' => 'Sort',
            'CORP_ID' => 'Corp  ID',
            'DEP_ID' => 'Dep  ID',
            'DEP_SUB_ID' => 'Dep  Sub  ID',
            'GF_ID' => 'Gf  ID',
            'SEQ_ID' => 'Seq  ID',
            'JOBGRADE_ID' => 'Jobgrade  ID',
            'CREATED_BY' => 'Created  By',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
            'STATUS' => 'Status',
        ];
    }
}
