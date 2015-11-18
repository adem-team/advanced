<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "u0005m".
 *
 * @property integer $ID
 * @property string $RGTR_TITEL
 * @property string $TGL
 * @property string $RGTR_ISI
 * @property string $RGTR_DCRPT
 * @property integer $SET_ACTIVE
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
class Regulasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0005m';
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
            [['ID'], 'required'],
            [['ID', 'SET_ACTIVE', 'GF_ID', 'SEQ_ID', 'STATUS'], 'integer'],
            [['TGL', 'UPDATED_TIME'], 'safe'],
            [['RGTR_ISI', 'RGTR_DCRPT'], 'string'],
            [['RGTR_TITEL'], 'string', 'max' => 255],
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
            'RGTR_TITEL' => 'Rgtr  Titel',
            'TGL' => 'Tgl',
            'RGTR_ISI' => 'Rgtr  Isi',
            'RGTR_DCRPT' => 'Rgtr  Dcrpt',
            'SET_ACTIVE' => 'Set  Active',
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
