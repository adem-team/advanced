<?php

namespace lukisongroup\hrd\models;

use Yii;

/**
 * This is the model class for table "key_list".
 *
 * @property integer $FunctionKey
 * @property string $FunctionKeyNM
 */
class Key_list extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'key_list';
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
            [['FunctionKey'], 'required'],
            [['FunctionKey'], 'integer'],
            [['FunctionKeyNM'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'FunctionKey' => 'Function Key',
            'FunctionKeyNM' => 'Function Key Nm',
        ];
    }
}
