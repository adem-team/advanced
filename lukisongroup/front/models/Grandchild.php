<?php

namespace lukisongroup\front\models;

use Yii;

/**
 * This is the model class for table "fr003".
 *
 * @property integer $GRANDCHILD_ID
 * @property integer $CHILD_ID
 * @property integer $PARENT_ID
 * @property string $GRANDCHILD
 */
class Grandchild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fr003';
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
            [['CHILD_ID', 'PARENT_ID'], 'integer'],
            [['GRANDCHILD'], 'string', 'max' => 70]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'GRANDCHILD_ID' => 'Grandchild  ID',
            'CHILD_ID' => 'Child  ID',
            'PARENT_ID' => 'Parent  ID',
            'GRANDCHILD' => 'Grandchild',
        ];
    }

    /**
     * @inheritdoc
     * @return GrandchildQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GrandchildQuery(get_called_class());
    }
}
