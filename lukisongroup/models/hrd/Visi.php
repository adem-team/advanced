<?php

namespace lukisongroup\models\hrd;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "u0004m".
 *
 * @property integer $ID
 * @property string $VISIMISI_TITEL
 * @property string $TGL
 * @property string $VISIMISI_ISI
 * @property string $VISIMISI_DCRPT
 * @property string $VISIMISI_IMG
 * @property integer $SET_ACTIVE
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
class Visi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */public $image;
    public static function tableName()
    {
        return 'u0004m';
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
			[['TGL', 'VISIMISI_ISI','VISIMISI_DCRPT','SET_ACTIVE', 'GF_ID', 'SEQ_ID', 'STATUS','VISIMISI_TITEL','DEP_ID', 'DEP_SUB_ID', 'JOBGRADE_ID'], 'required'],
            [['TGL', 'UPDATED_TIME'], 'safe'],
            [['VISIMISI_ISI', 'VISIMISI_DCRPT'], 'string'],
            [['SET_ACTIVE', 'GF_ID', 'SEQ_ID', 'STATUS'], 'integer'],
            [['VISIMISI_TITEL'], 'string', 'max' => 255],
            [['VISIMISI_IMG', 'CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50],
            [['CORP_ID'], 'string', 'max' => 5],
            [['DEP_ID', 'DEP_SUB_ID', 'JOBGRADE_ID'], 'string', 'max' => 6],
			     [['image'], 'file', 'extensions'=>'jpg, gif, png']
        ];
    }

    /**
     * @inheritdoc
     */
	  public function getImageFile() 
    {
        return isset($this->VISIMISI_IMG) ? Yii::$app->params['uploadPath'] . $this->VISIMISI_IMG : null;
    }
	
    public function getImageUrl() 
    {
        // return a default image placeholder if your source IMAGE is not found
        $IMAGE = isset($this->VISIMISI_IMG) ? $this->VISIMISI_IMG : 'default_user.jpg';
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
        $this->VISIMISI_IMG= 'lukison-'.date('ymdHis').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $image;
    }
	
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'VISIMISI_TITEL' => 'Visimisi  Titel',
            'TGL' => 'Tgl',
            'VISIMISI_ISI' => 'Visimisi  Isi',
            'VISIMISI_DCRPT' => 'Visimisi  Dcrpt',
            'VISIMISI_IMG' => 'Visimisi  Img',
            'SET_ACTIVE' => 'Set  Active',
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
