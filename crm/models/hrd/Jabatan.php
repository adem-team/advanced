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
 *  JABATAN CLASS Author: -ptr.nov-	
 */
class Jabatan extends \yii\db\ActiveRecord
{
	/* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- : UMUM */
        return \Yii::$app->db4;
    }
	
	/* [2] TABLE SELECT */
    public static function tableName()
    {
        return '{{dbm000.a0003}}';   
	}

	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['JAB_ID','JAB_NM'], 'required'],
            [['JAB_ID'], 'string', 'max' => 5],
            [['JAB_NM','JAB_DCRP'], 'string'],
			[['SORT'], 'integer'],
        ];
    }

	/* [4] ATRIBUTE LABEL -> DetailView/GridView */
    public function attributeLabels()
    {
        return [
            'JAB_ID' => Yii::t('app', 'Dept.ID'),
            'JAB_NM' => Yii::t('app', 'Name'),
            'JAB_STS' => Yii::t('app', 'Status'),
            'JAB_AVATAR' => Yii::t('app', 'Avatar'),
            'JAB_DCRP' => Yii::t('app', 'Description'),
            'SORT' => Yii::t('app', 'Sorting'),
        ];
    }
}


