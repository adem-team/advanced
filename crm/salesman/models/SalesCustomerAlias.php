<?php

namespace crm\salesman\models;

use Yii;

/**
 * This is the model class for table "c0002".
 *
 * @property string $ID
 * @property string $KD_CUSTOMERS
 * @property string $KD_ALIAS
 * @property string $KD_DISTRIBUTOR
 * @property string $DIS_REF
 * @property integer $KD_PARENT
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_AT
 */
class SalesCustomerAlias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002';
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
            [['KD_PARENT'], 'required'],
            [['KD_PARENT'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_CUSTOMERS', 'KD_ALIAS'], 'string', 'max' => 30],
            [['KD_DISTRIBUTOR', 'DIS_REF'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_CUSTOMERS' => 'Kd  Customers',
            'KD_ALIAS' => 'Kd  Alias',
            'KD_DISTRIBUTOR' => 'Kd  Distributor',
            'DIS_REF' => 'Dis  Ref',
            'KD_PARENT' => 'Kd  Parent',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
