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
 * DEPARTMENT CLASS  Author: -ptr.nov-
 */
class Modulset extends \yii\db\ActiveRecord
{
	/* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->db4;
    }
	
	/* [2] TABLE SELECT */
    public static function tableName()
    {
        return '{{dbm002.b0004}}';
    }

	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['MDL_ID','MDL_NM'], 'required'],
            [['MDL_ID','MDL_STS'], 'integer'],
            [['MDL_NM'], 'string', 'max' => 50],
			[['MDL_DCRP'], 'string'],
			[['SORT'], 'integer'],
        ];
    }

	/* [4] ATRIBUTE LABEL -> DetailView/GridView */
    public function attributeLabels()
    {
        return [
            'MDL_ID' => Yii::t('app', 'Mdl.ID'),
            'DEP_NM' => Yii::t('app', 'Name'),
            'MDL_STS' => Yii::t('app', 'Status'),
            'MDL_DCRP' => Yii::t('app', 'Description'),
            'SORT' => Yii::t('app', 'Sorting'),
        ];
    }
}


