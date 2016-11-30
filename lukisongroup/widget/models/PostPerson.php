<?php

namespace lukisongroup\widget\models;

/*extensions */
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;

/* namespace models */
use lukisongroup\widget\models\NotulenModul;

/**
 * This is the model class for table "c0006".
 *
 * @property integer $ID
 * @property string $INVES_TYPE
 * @property integer $STATUS
 * @property string $KETERANGAN
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class PostPerson extends Model
{

    public $Person;
    public $NotulenId;

    /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                ['Person', 'required'],
                [['Person', 'NotulenId'], 'safe'],
            ];
        }



    /**
     * save the post's account (*3)
     */
    public function saveAccount()
    {
           
           if($this->Person[0] == 'selected'){
             $data_id_slice = array_slice($this->Person,1);
           }else{
              $data_id_slice = $this->Person;
           }

            $data_id = implode(",",$data_id_slice);
           
           $rows = (new \yii\db\Query())
                    ->select(["CONCAT(em.EMP_NM, ' ',em.EMP_NM_BLK) AS full_name"])
                    ->from('dbm001.user us')
                    ->leftjoin('dbm002.a0001 as em','em.EMP_ID = us.EMP_ID')
                    ->where(['us.id' => $data_id_slice])
                    ->all();
           foreach ($rows as $key => $value) {
               # code...
               $val[] = $value['full_name'];
           }
           $data_fullname = implode(',',$val);

           $transaction = Notulen::getDb()->beginTransaction();

            try {
                  $execute = Yii::$app->db_widget->createCommand()->update('m0002',['USER_ID'=>$data_id],'NOTULEN_ID="'.$this->NotulenId.'"')->execute();


               $execute2 = Yii::$app->db_widget->createCommand()->update('m0001',['USER_ID'=>$data_id],'id="'.$this->NotulenId.'"')->execute(); 

                        // ...other DB operations...
                        $transaction->commit();
                    } catch(\Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }

            

       
 
        
       
               //     # code...
                // $pc = NotulenModul::find()->where(['NOTULEN_ID'=>$this->NotulenId])->one();
                // $pc->USER_ID = ;
                // $pc->save();
               



    }




}
