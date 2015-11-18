<?php

namespace lukisongroup\front\models;
use lukisongroup\front\models\Parents;
use lukisongroup\front\models\Child;

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
    public function getParents()
    {
        return $this->hasOne(Parents::className(), ['parent_id' => 'PARENT_ID']);
    }
 
/* Getter for country name */
    public function getParentsName()
     {
        return $this->parents['parent'];
     }
     public function getChild()
    {
        return $this->hasOne(Child::className(), ['CHILD_ID' => 'CHILD_ID']);
    }
 
/* Getter for country name */
    public function getChildName()
     {
        return $this->child['CHILD_NAME'];
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
            'parentsName' => Yii::t('app', 'Nama Parent'),
            'childName' => Yii::t('app', 'Nama Child'),
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
