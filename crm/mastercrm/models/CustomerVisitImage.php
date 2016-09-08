<?php

namespace crm\mastercrm\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_img".
 *
 * @property string $ID
 * @property string $ID_DETAIL
 * @property string $IMG_NM
 * @property string $IMG_DECODE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class CustomerVisitImage extends \yii\db\ActiveRecord
{
	public $image_start;
	public $image_end;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_img';
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
            [['CUSTOMER_ID','IMG_DECODE_START', 'IMG_DECODE_END'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT', 'TIME_END', 'TIME_START'], 'safe'],
            [['ID_DETAIL'], 'string', 'max' => 20],
            [['IMG_NM_START', 'IMG_NM_END'], 'string', 'max' => 255],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100],
			[['image_start','image_end'],'file', 'extensions'=>'jpg, gif, png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ID_DETAIL' => 'Id  Detail',
            'IMG_NM_START' => 'Img  Nm  Start',
            'IMG_DECODE_START' => 'Img  Decode  Start',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
            'IMG_DECODE_END' => 'Img  Decode  End',
            'IMG_NM_END' => 'Img  Nm  End',
            'TIME_END' => 'Time  End',
            'TIME_START' => 'Time  Start',
			
        ];
    }
}
