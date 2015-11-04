<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "u0003a".
 *
 * @property integer $GF_ID
 * @property string $GF_NM
 * @property integer $SORT
 */
class Groupfunction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0003a';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [          
            [['GF_NM'], 'string', 'max' => 30],
			[['SORT', 'STATUS'], 'integer'],
            [['GF_DCRP'], 'string'],            
			[['CREATED_BY','UPDATED_BY'], 'string', 'max' => 50],
			[['UPDATED_TIME'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GF_ID' => 'Group Function.ID',
            'GF_NM' => 'GRoup.Function',
            'SORT' => 'Sort',		
            'STATUS' => 'Status',
            'GF_DCRP' => 'Discription',
			'CREATED_BY'=> 'Created',
			'UPDATED_BY'=> 'Updated',
			'UPDATED_TIME'=> 'DateTime',
        ];
    }
}
