<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\models\hrd;
use kartik\builder\Form;
use Yii;

/**
 * CORPORATION CLASS Author: -ptr.nov-
 */
class Corp extends \yii\db\ActiveRecord
{
	/* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- : UMUM */
        return \Yii::$app->db2;
    }

	/* [2] TABLE SELECT */
    public static function tableName()
    {
        //return '{{dbm000.a0001}}';
		return '{{u0001}}';
    }

	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['CORP_ID','CORP_NM'], 'required'],
            [['CORP_ID'], 'string', 'max' => 5],
            [['CORP_NM'], 'string', 'max' => 30],
			[['CORP_DCRP'],'string'],
			[['CREATED_BY','UPDATED_BY'], 'string', 'max' => 50],
			[['UPDATED_TIME'],'safe'],
         ];
    }

    public function attributeLabels()
    {
        return [
            'CORP_ID' => Yii::t('app', 'Corp.ID'),
            'CORP_NM' => Yii::t('app', 'Corp.Name'),
            'CORP_STS' => Yii::t('app', 'Status'),
            'CORP_AVATAR' => Yii::t('app', 'Avatar'),
            'CORP_DCRP' => Yii::t('app', 'Description'),
            'SORT' => Yii::t('app', 'Sorting'),
        ];
    }
}


