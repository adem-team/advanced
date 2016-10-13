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
       $data = implode(",",$this->Person);
        $execute = Yii::$app->db_widget->createCommand()->update('m0002',['USER_ID'=>$data],'NOTULEN_ID="'.$this->NotulenId.'"')->execute(); 

               //     # code...
                // $pc = NotulenModul::find()->where(['NOTULEN_ID'=>$this->NotulenId])->one();
                // $pc->USER_ID = ;
                // $pc->save();
               



    }




}
