<?php

namespace lukisongroup\widget\models;
use Yii;

/*LABEL WEEK*/
class Cnfweek extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cnfweek';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'start', 'end', 'bulan', 'tahun'], 'required'],
            [['label',], 'string'],
            [['start', 'end','TITLE1'], 'date'],
            [['bulan', 'tahun'], 'integer']
        ];
    }

    public function fields()
	{
		return [
			'start'=>function($model){
							return Yii::$app->ambilKonvesi->convert($model->start,'date');
					},			
			'end'=>function($model){
							return Yii::$app->ambilKonvesi->convert($model->end,'date');
					},	
			'label',
		];
	}
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            //'label' => 'Labelxxss',
            'start' => 'Start s',
            'end' => 'End',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
			 'label' =>Yii::t('app', 'LABEL'),
        ];
    }
	
	
}
