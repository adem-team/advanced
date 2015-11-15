<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "u0003c".
 *
 * @property integer $ID
 * @property string $JOBGRADE_ID
 * @property string $JOBGRADE_NM
 * @property integer $SORT
 * @property integer $JOBGRADE_STS
 * @property string $JOBGRADE_DCRP
 */
class Jobgrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0003c';
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
            [['JOBGRADE_ID'], 'required'],
            [['SORT', 'JOBGRADE_STS'], 'integer'],
            [['JOBGRADE_DCRP'], 'string'],
            [['JOBGRADE_ID'], 'string', 'max' => 5],
            [['JOBGRADE_NM'], 'string', 'max' => 100],
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
            'ID' => 'ID',
            'JOBGRADE_ID' => 'Jobgrade.ID',
            'JOBGRADE_NM' => 'Grading',
            'SORT' => 'Sort',
            'JOBGRADE_STS' => 'Status',
            'JOBGRADE_DCRP' => 'Discription',
			'CREATED_BY'=> 'Created',
			'UPDATED_BY'=> 'Updated',
			'UPDATED_TIME'=> 'DateTime',
        ];
    }
}
