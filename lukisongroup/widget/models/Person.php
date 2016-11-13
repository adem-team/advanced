<?php

namespace lukisongroup\widget\models;

use Yii;

/**
 * This is the model class for table "m0003".
 *
 * @property integer $ID
 * @property integer $NOTULEN_ID
 * @property string $PERSON_NAME
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'm0003';
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
            [['NOTULEN_ID'], 'integer'],
            [['PERSON_NAME'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NOTULEN_ID' => 'Notulen  ID',
            'PERSON_NAME' => 'Person  Name',
        ];
    }
}
