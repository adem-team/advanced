<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "u0003b".
 *
 * @property integer $SEQ_ID
 * @property string $SEQ_NM
 * @property string $SEQ_DCRP
 * @property integer $SORT
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 */
class Seq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'u0003b';
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
            [['SEQ_DCRP'], 'string'],
            [['SORT'], 'required'],
            [['SORT', 'STATUS'], 'integer'],
            [['UPDATED_TIME'], 'safe'],
            [['SEQ_NM'], 'string', 'max' => 25],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SEQ_ID' => 'Seq  ID',
            'SEQ_NM' => 'Seq  Nm',
            'SEQ_DCRP' => 'Seq  Dcrp',
            'SORT' => 'Sort',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
        ];
    }
}
