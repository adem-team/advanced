<?php

namespace lukisongroup\master\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "b0002".
 *
 * @property integer $ID
 * @property string $KD_BARANG
 * @property string $KD_ALIAS
 * @property string $KD_DISTRIBUTOR
 * @property integer $KD_PARENT
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class Barangalias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $NM_BARANG;
    public static function tableName()
    {
        return 'b0002';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    public function getBrg()
    {
        return $this->hasOne(Barang::className(), ['KD_BARANG' => 'KD_BARANG']);
    }

    public function getBrgnm()
    {
      # code...
      return $this->brg->NM_BARANG;
    }


    public function getDis()
    {
        return $this->hasOne(Distributor::className(), ['KD_DISTRIBUTOR' => 'KD_DISTRIBUTOR']);
    }

    public function getDisnm()
    {
      # code...
      return $this->dis->NM_DISTRIBUTOR;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_PARENT'], 'integer'],
            [['KD_ALIAS'], 'required'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_BARANG', 'KD_ALIAS'], 'string', 'max' => 30],
            [['KD_DISTRIBUTOR'], 'string', 'max' => 50],
            [['KD_ALIAS'], 'validalias'],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    public function validalias($model)
    {
      # code...
    	 $kondisiTrue = Barangalias::find()->where("KD_ALIAS='".$this->KD_ALIAS. "' AND KD_DISTRIBUTOR='".$this->KD_DISTRIBUTOR."'")->one();
       if($kondisiTrue)
       {
           $this->addError($model, 'Duplicated code because the code already exists in this distributor !, attention Better change name distributor or change code ');
       }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_BARANG' => 'Nama Barang',
            'KD_ALIAS' => 'Alias Kode Barang',
            'KD_DISTRIBUTOR' => 'Nama Distributor',
            'KD_PARENT' => 'Jenis Barang',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
