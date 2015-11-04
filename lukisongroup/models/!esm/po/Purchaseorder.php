<?php

namespace lukisongroup\models\esm\po;

use Yii;


/**
 * This is the model class for table "p0001".
 *
 * @property string $ID
 * @property string $KD_PO
 * @property string $KD_SUPPLIER
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $APPROVE_BY
 * @property string $APPROVE_AT
 * @property integer $STATUS
 * @property string $NOTE
 */
class Purchaseorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0001';
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
			['KD_SUPPLIER', 'required', 'message' => 'Please choose a username.'],
            [['KD_PO', 'CREATE_BY', 'CREATE_AT', 'APPROVE_BY', 'APPROVE_AT', 'STATUS', 'NOTE'], 'safe'],
            [['CREATE_AT', 'APPROVE_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['KD_PO'], 'string', 'max' => 30],
            [['KD_SUPPLIER', 'CREATE_BY', 'APPROVE_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PO' => 'Kd  Po',
            'KD_SUPPLIER' => 'Kd  Supplier',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'APPROVE_BY' => 'Approve  By',
            'APPROVE_AT' => 'Approve  At',
            'STATUS' => 'Status',
            'NOTE' => 'Note',
        ];
    }
}
