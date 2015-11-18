<?php

namespace lukisongroup\front\models;

use Yii;

/**
 * This is the model class for table "fr000".
 *
 * @property integer $CHILD_ID
 * @property integer $PARENT_ID
 * @property string $CHILD_NAME
 */
class Child extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fr000';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PARENT_ID'], 'integer'],
            [['CHILD_NAME'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CHILD_ID' => 'Child  ID',
            'PARENT_ID' => 'Parent  ID',
            'CHILD_NAME' => 'Child  Name',
        ];
    }

    /**
     * @inheritdoc
     * @return ChildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChildQuery(get_called_class());
    }
}
