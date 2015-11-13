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
class Dept extends \yii\db\ActiveRecord
{
	/* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->db2;
    }
	
	/* [2] TABLE SELECT */
    public static function tableName()
    {
        //return '{{dbm000.a0002}}';
		return '{{u0002a}}';
    }

	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['DEP_ID','DEP_NM'], 'required'],
            [['DEP_ID'], 'string', 'max' => 5],
            [['DEP_NM'], 'string', 'max' => 30],
			[['DEP_DCRP'], 'string'],
			[['SORT'], 'integer'],
			[['CREATED_BY','UPDATED_BY'], 'string', 'max' => 50],
			[['UPDATED_TIME'],'safe'],
        ];
    }

	/* [4] ATRIBUTE LABEL -> DetailView/GridView */
    public function attributeLabels()
    {
        return [
            'DEP_ID' => Yii::t('app', 'Dept.ID'),
            'DEP_NM' => Yii::t('app', 'Name'),
            'DEP_STS' => Yii::t('app', 'Status'),
            'DEP_AVATAR' => Yii::t('app', 'Avatar'),
            'DEP_DCRP' => Yii::t('app', 'Description'),
            'SORT' => Yii::t('app', 'Sorting'),
			'CREATED_BY'=> Yii::t('app','Created'),
			'UPDATED_BY'=> Yii::t('app','Updated'),
			'UPDATED_TIME'=> Yii::t('app','DateTime'),
        ];
    }
}


