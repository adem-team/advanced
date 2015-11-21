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
 *  STATUS CLASS Author: -ptr.nov-	
 */
class Status extends \yii\db\ActiveRecord
{
	/* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- */
        return \Yii::$app->db2;
    }
	
	/* [2] TABLE SELECT */
    public static function tableName()
    {
        return '{{%b0009}}';
    }

	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['STS_ID'], 'required'],
            [['STS_ID'], 'integer'],
            [['STS_NM'], 'string', 'max' => 30],
			[['SORT'], 'integer'],
        ];
    }
	
	/* [4] ATRIBUTE LABEL -> DetailView/GridView */
    public function attributeLabels()
    {
        return [
            'STS_ID' => Yii::t('app', 'Status.ID'),
            'STS_NM' => Yii::t('app', 'Status'),
            'STS_COLOR' => Yii::t('app', 'Status'),
            'STS_DCRP' => Yii::t('app', 'Description'),
            'SORT' => Yii::t('app', 'Sorting'),
        ];
    }
}


