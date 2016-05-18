<?php

namespace lukisongroup\widget\models;

use Yii;
use lukisongroup\hrd\models\corp;
use lukisongroup\hrd\models\dept;

/**
 * This is the model class for table "a1000".
 *
 * @property integer $ID
 * @property string $KD_BERITA
 * @property string $JUDUL
 * @property string $ISI
 * @property string $KD_CORP
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property string $DATA_PICT
 * @property string $DATA_FILE
 * @property integer $STATUS
 * @property string $CREATED_ATCREATED_BY
 * @property string $CREATED_BY
 * @property string $UPDATE_AT
 * @property string $DATA_ALL
 */
class Berita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $CREATED_AT;
     public $CREATE_AT;
    public static function tableName()
    {
        return 'bt0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
      *@author: wawan
      *before save implode USER_CC
      *@return parent beforeSave
    */
    public function beforeSave($insert)
     {
          $user_cc = implode(",", $this->USER_CC);
          $this->USER_CC = $user_cc;
          return parent::beforeSave($insert);
      }

      /**
        *@author: wawan
        *@return relational database corp
      */
    public function getCorp()
      {
         return $this->hasOne(Corp::className(), ['CORP_ID' => 'KD_CORP']);
      }

      /**
        *@author: wawan
        *@return relational database Departement
      */
      public function getDept()
        {
           return $this->hasOne(Dept::className(), ['DEP_ID' => 'KD_DEP']);
        }

        /**
          *@author: wawan
          *get CORP_NM
          *@return relational database corp
        */
      public function getcorpnnm()
      {
        # code...
        return $this->corp->CORP_NM;
      }

      /**
        *@author: wawan
        *get CORP_NM || outbox(widget)
        *@return relational database corp
      */
    public function getCorpnm()
    {
      # code...
      return $this->corp->CORP_NM;
    }

    /**
      *@author: wawan
      *get CORP_NM || history(widget)
      *@return relational database corp
    */
  public function getCorphistory()
  {
    # code...
    return $this->corp->CORP_NM;
  }

  /**
    *@author: wawan
    *get DEP_NM || history(widget)
    *@return relational database Departement
  */
public function getDepthistory()
{
  # code...
  return $this->dept->DEP_NM;
}


      /**
        *@author: wawan
        *get DEP_NM
        *@return relational database Departement
      */
    public function getdeptnm()
    {
      # code...
      return $this->dept->DEP_NM;
    }

    /**
      *@author: wawan
      *get DEP_NM || outbox(widget)
      *@return relational database Departement
    */
  public function getDeptmn()
  {
    # code...
    return $this->dept->DEP_NM;
  }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['JUDUL'], 'required','on' => 'true'], // ajax validation checkbox value equal true
            [['JUDUL','USER_CC','KD_DEP','ISI'], 'required'],// ajax validation
            [['ISI', 'DATA_PICT', 'DATA_FILE', 'DATA_ALL','KD_BERITA','KD_REF'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_ATCREATED_BY', 'UPDATE_AT','USER_CC'], 'safe'],
            [['KD_BERITA', 'KD_CORP', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 20],
            [['JUDUL'], 'string', 'max' => 200],
            [['CREATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'alluser'=>'',
            'ID' => 'ID',
            'KD_BERITA' => 'Kd  Berita',
            'JUDUL' => 'Judul',
            'ISI' => 'Isi',
            'KD_CORP' => 'Kd  Corp',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'DATA_PICT' => 'Data  Pict',
            'DATA_FILE' => 'Data  File',
            'STATUS' => 'Status',
            'CREATED_ATCREATED_BY' => 'Created  Atcreated  By',
            'CREATED_BY' => 'Created  By',
            'UPDATE_AT' => 'Update  At',
            'DATA_ALL' => 'Data  All',
        ];
    }
}
