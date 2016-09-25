<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "sc0001a".
 *
 * @property integer $ID
 * @property integer $TYPE
 */

class Postpilot extends Model
{
  
    /**
     * @inheritdoc
     */
    public $isparent;
    public $srcparent;
    public $title;
    public function rules()
    {
        return [
            [['isparent'], 'integer'],
             [['srcparent','title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'isparent' => 'Isparent',
            'srcparent' => 'Srcparent',
            'title'=>'title'
        ];
    }
}
