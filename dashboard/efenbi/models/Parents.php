<?php

namespace lukisongroup\front\models;

use Yii;

/**
 * This is the model class for table "fr001".
 *
 * @property integer $parent_id
 * @property string $parent
 */
class Parents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fr001';
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
            [['parent'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Parent ID',
            'parent' => 'Parent',
        ];
    }

    /**
     * @inheritdoc
     * @return ParentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParentsQuery(get_called_class());
    }
}
