<?php

namespace lukisongroup\master\models;

use Yii;

/**
 * This is the model class for table "c0021b".
 *
 * @property integer $ID
 * @property string $TGL
 * @property integer $SOP_ID
 * @property double $SCORE_RSLT
 * @property double $SCORE_PERCENT_MIN
 * @property double $SCORE_PERCENT_MAX
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 */
class SopSalesDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0021b';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL', 'CREATE_AT'], 'safe'],
            [['SOP_ID'], 'integer'],
            [['SCORE_RSLT', 'SCORE_PERCENT_MIN', 'SCORE_PERCENT_MAX'], 'number'],
            [['CREATE_BY'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL' => 'Tgl',
            'SOP_ID' => 'Sop  ID',
            'SCORE_RSLT' => 'Score  Rslt',
            'SCORE_PERCENT_MIN' => 'Score  Percent  Min',
            'SCORE_PERCENT_MAX' => 'Score  Percent  Max',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
        ];
    }
}
