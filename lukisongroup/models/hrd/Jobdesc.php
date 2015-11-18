<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "u0006m".
 *
 * @property integer $ID
 * @property string $JOBSDESK_TITLE
 * @property string $JOBGRADE_NM
 * @property string $JOBGRADE_DCRP
 * @property integer $JOBGRADE_STS
 * @property string $JOBSDESK_IMG
 * @property string $JOBSDESK_PATH
 * @property integer $SORT
 * @property string $CORP_ID
 * @property string $DEP_ID
 * @property string $DEP_SUB_ID
 * @property integer $GF_ID
 * @property integer $SEQ_ID
 * @property string $JOBGRADE_ID
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
class Jobdesc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0006m';
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
            [['JOBGRADE_DCRP'], 'string'],
            [['JOBGRADE_STS', 'SORT', 'GF_ID', 'SEQ_ID', 'STATUS'], 'integer'],
            [['UPDATED_TIME'], 'safe'],
            [['JOBSDESK_TITLE'], 'string', 'max' => 255],
            [['JOBGRADE_NM', 'JOBSDESK_IMG', 'JOBSDESK_PATH'], 'string', 'max' => 100],
            [['CORP_ID'], 'string', 'max' => 5],
            [['DEP_ID', 'DEP_SUB_ID', 'JOBGRADE_ID'], 'string', 'max' => 6],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'JOBSDESK_TITLE' => 'Jobsdesk  Title',
            'JOBGRADE_NM' => 'Jobgrade  Nm',
            'JOBGRADE_DCRP' => 'Jobgrade  Dcrp',
            'JOBGRADE_STS' => 'Jobgrade  Sts',
            'JOBSDESK_IMG' => 'Jobsdesk  Img',
            'JOBSDESK_PATH' => 'Jobsdesk  Path',
            'SORT' => 'Sort',
            'CORP_ID' => 'Corp  ID',
            'DEP_ID' => 'Dep  ID',
            'DEP_SUB_ID' => 'Dep  Sub  ID',
            'GF_ID' => 'Gf  ID',
            'SEQ_ID' => 'Seq  ID',
            'JOBGRADE_ID' => 'Jobgrade  ID',
            'CREATED_BY' => 'Created  By',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
            'STATUS' => 'Status',
        ];
    }
}
