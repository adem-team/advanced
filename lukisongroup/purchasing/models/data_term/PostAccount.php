<?php

namespace lukisongroup\purchasing\models\data_term;

/*extensions */
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;

/* namespace models */
use lukisongroup\purchasing\models\data_term\Termdetail;
use lukisongroup\master\models\Terminvest;

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
class PostAccount extends Model
{

    public $INVES_ID;

    public $invest_ids;
    public $term_id;

    /**
         * @return array the validation rules.
         */
        public function rules()
        {
            return [
                ['INVES_ID', 'required'],
                ['INVES_ID', 'exist', 'targetClass' => Terminvest::className(), 'targetAttribute' => 'ID'],
                ['invest_ids', 'each', 'rule' => [
                    'exist', 'targetClass' => Termdetail::className(), 'targetAttribute' => 'INVES_ID'
                ]],
            ];
        }



    /**
     * save the post's account (*3)
     */
    public function saveAccount()
    {

        $this->invest_ids = [];

        $pcs = Terminvest::find()->where(['ID' => $this->INVES_ID])->all();

        if (is_array($this->invest_ids)) {
            foreach($pcs as $key => $value) {
                $pc = new Termdetail();
                $pc->TERM_ID = $this->term_id;
                $pc->INVES_ID = $value->ID;
                $pc->save();

            }

        }
    }

    /**
     * Get all the available Account (*4)
     * @return array available Account
     */
    public static function getAvailableAccount()
    {
      //query list in listbox = _account
        $invets = Yii::$app->db_esm->createCommand("SELECT * FROM `c0006` c6  WHERE  NOT EXISTS (SELECT INVES_ID FROM `t0000detail` `td` WHERE td.INVES_ID = c6.ID)")->queryAll();
        $items = ArrayHelper::map($invets, 'ID', 'INVES_TYPE');
        return $items;
    }


}
