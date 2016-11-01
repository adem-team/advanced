<?php

namespace lukisongroup\purchasing\models\rqt;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "t0001header".
 *
 * @property string $KD_RIB
 * @property string $TGL
 * @property string $CUST_ID_PARENT
 * @property string $KD_CORP
 * @property string $KD_COSTCENTER
 * @property string $PPN
 * @property string $PPH23
 * @property string $NOTE
 * @property string $ID_USER
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property integer $STATUS
 * @property string $CREATED_AT
 * @property string $UPDATED_ALL
 * @property string $DATA_ALL
 * @property string $EMP_NM
 * @property string $USER_CC
 * @property string $SIG1_ID
 * @property string $SIG1_NM
 * @property string $SIG1_TGL
 * @property string $SIG1_SVGBASE64
 * @property string $SIG1_SVGBASE30
 * @property string $SIG2_ID
 * @property string $SIG2_NM
 * @property string $SIG2_TGL
 * @property string $SIG2_SVGBASE64
 * @property string $SIG2_SVGBASE30
 * @property string $SIG3_ID
 * @property string $SIG3_NM
 * @property string $SIG3_TGL
 * @property string $SIG3_SVGBASE64
 * @property string $SIG3_SVGBASE30
 */
class DetailListSearch extends DetailList
{
    /**
     * @inheritdoc
     */


  

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['LIST_ALL','TERM_ID','KD_RIB'], 'safe'],
            [['ID_INVEST'], 'integer'],
        ];
    }

    public function search($params,$id)
    {
       

        $query = DetailList::find()->where(['KD_RIB'=>$id]);
               
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            //return $dataProvider;
            //$dataProvider->query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere(['like', 'KD_RIB', $this->KD_RO])
        //         ->andFilterWhere(['like', 'r0001.KD_CORP', $this->getAttribute('corp.CORP_NM')])
        //         ->andFilterWhere(['like', 'EMP_NM', $this->EMP_NM])
        //         ->andFilterWhere(['like', 'u0002a.DEP_NM', $this->getAttribute('dept.DEP_NM')]);


        // if($this->CREATED_AT!=''){
        //     $date_explode = explode(" - ", $this->CREATED_AT);
        //     $date1 = trim($date_explode[0]);
        //     $date2= trim($date_explode[1]);
        //     $query->andFilterWhere(['between','CREATED_AT', $date1,$date2]);
        // }

        return $dataProvider;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'LIST_ALL' => 'LIST ALL',
           
        ];
    }
}
