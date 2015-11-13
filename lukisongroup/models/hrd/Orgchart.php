<?php

namespace lukisongroup\models\hrd;

use Yii;

/**
 * This is the model class for table "c0006".
 *
 * @property string $id
 * @property string $parentid
 * @property string $title
 * @property string $description
 * @property string $phone
 * @property string $email
 * @property string $photo
 * @property integer $itemtype
 */
class Orgchart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0006';
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
            [['id', 'title'], 'required'],
            [['id', 'parent', 'itemType'], 'integer'],
            [['title', 'phone', 'email', 'image'], 'string', 'max' => 120],
            [['description'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'title' => 'Title',
            'description' => 'Description',
            'phone' => 'Phone',
            'email' => 'Email',
            'image' => 'Photo',
            'itemType' => 'Itemtype',
        ];
    }
}
