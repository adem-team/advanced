<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "u0003m".
 *
 * @property integer $ID
 * @property integer $GF_ID
 * @property integer $SEQ_ID
 * @property string $JOBGRADE_ID
 * @property string $JOBGRADE_NM
 * @property integer $SORT
 * @property integer $JOBGRADE_STS
 * @property string $JOBGRADE_DCRP
 */
class Jobgrademodul extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0003m';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }
	/* Join Class Group Function */
	public function getGroupfunction()
	{
		return $this->hasOne(Groupfunction::className(), ['GF_ID' => 'GF_ID']);
	}		
			
	/* Join Class Group Seqmen bisnis dan support */
	public function getGroupseqmen()
	{
		return $this->hasOne(Groupseqmen::className(), ['SEQ_ID' => 'SEQ_ID']);
	}	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GF_ID', 'SEQ_ID', 'SORT', 'JOBGRADE_STS'], 'integer'],
            [['SEQ_ID', 'JOBGRADE_ID'], 'required'],
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
            'GF_ID' => 'Gf  ID',
            'SEQ_ID' => 'Seq  ID',
            'JOBGRADE_ID' => 'Jobgrade  ID',
            'JOBGRADE_NM' => 'Jobgrade  Nm',
            'SORT' => 'Sort',
            'JOBGRADE_STS' => 'Jobgrade  Sts',
            'JOBGRADE_DCRP' => 'Jobgrade  Dcrp',
			'CREATED_BY'=> 'Created',
			'UPDATED_BY'=> 'Updated',
			'UPDATED_TIME'=> 'DateTime',
        ];
    }
}
