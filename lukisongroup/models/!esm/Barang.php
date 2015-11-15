<?php

namespace lukisongroup\models\esm;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "b0001".
 *
 * @property string $ID
 * @property string $KD_BARANG
 * @property string $NM_BARANG
 * @property string $KD_SUPPLIER
 * @property string $KD_DISTRIBUTOR
 * @property string $HPP
 * @property integer $harga
 * @property integer $barcode
 * @property integer $note
 * @property integer $status
 * @property integer $createdBy
 * @property integer $createdAt
 * @property integer $updateAt
 * @property string $data_all
 */
 
Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/barangesm/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/barangesm/';
 
class Barang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

	public $image;

    public static function tableName()
    {
        return 'b0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }
	
	public function getUnitb()
    {
        return $this->hasOne(Unitbarang::className(), ['ID' => 'KD_UNIT']);
    }
	public function getUnitbrg()
    {
        return $this->unitb->NM_UNIT;
    }
	
	public function getDbtr()
    {
        return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR' => 'KD_DISTRIBUTOR']);
    }
	public function getNmdbtr()
    {
        return $this->dbtr->NM_DISTRIBUTOR;
    }
	
	public function getBrg()
    {
        return $this->hasOne(Barangmaxi::className(), ['KD_BARANG' => 'NM_BARANG']);
    }
	
	public function getTbesm()
    {
        return $this->hasMany(Barang::className(), ['KD_BARANG' => 'KD_TYPE']);
    }
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_BARANG', 'KD_TYPE', 'KD_KATEGORI', 'NM_BARANG', 'HPP', 'HARGA', 'STATUS', 'KD_UNIT','KD_DISTRIBUTOR'], 'required'],
            [['HPP', 'HARGA', 'BARCODE'], 'integer'],
            [['CREATED_BY', 'UPDATED_AT', 'KD_SUPPLIER', 'KD_DISTRIBUTOR'], 'string'],
			[['image'], 'file', 'extensions'=>'jpg, gif, png'],
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
        $this->IMAGE = 'lukison-'.date('ymdHis').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";
 
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
            'KD_TYPE' => 'Tipe',
            'KD_BARANG' => 'Kode Barang',
            'KD_KATEGORI' => 'Kategori',
            'NM_BARANG' => 'Nama Barang',
            'KD_UNIT' => 'Unit',
            'KD_SUPPLIER' => 'Supplier',
            'KD_DISTRIBUTOR' => 'Distributor',
            'HPP' => 'HPP',
            'HARGA' => 'Harga Jual',
            'BARCODE' => 'Barcode',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_AT' => 'Update At',
            'DATAA_ALL' => 'Data All',
            'nmdbtr' => Yii::t('app', 'Nama Distributor'),
            'unitbrg' => Yii::t('app', 'Unit'),
        ];
    }
}
