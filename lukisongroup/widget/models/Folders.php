<?php

namespace lukisongroup\widget\models;

use Yii;



class Folders extends \yii\db\ActiveRecord
{
    use kartik\tree\models\TreeTrait;

    /**
     * @inheritdoc reuired Tree models kartik tree view
     * @property string  $id
     * @property string  $root
     * @property string  $lft
     * @property string  $rgt
     * @property integer $lvl
     * @property string  $name
     * @property string  $icon
     * @property int     $icon_type
     * @property bool    $active
     * @property bool    $selected
     * @property bool    $disabled
     * @property bool    $readonly
     * @property bool    $visible
     * @property bool    $collapsed
     * @property bool    $movable_u
     * @property bool    $movable_d
     * @property bool    $movable_l
     * @property bool    $movable_r
     * @property bool    $removable
     * @property bool    $removable_all
     */

    public $selected;
    public $collapsed;
    public $movable_u;
    public $movable_d;
    public $movable_l;
    public $movable_r;
    public $removable;
    public $removable_all;

    public static function tableName()
    {
        return 'folders';
    }  


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['path'], 'required'],
            // [['path'], 'default', 'value' => $this->name],
            // [['category'], 'string', 'max' => 64],
            // [['path'], 'string', 'max' => 255],
            // [['storage'], 'string', 'max' => 32],
            [['name'], 'unique'],
            [['root','name','active','lft','rgt','lvl','icon','icon_type','path'], 'safe']
        ];
    }

   

   
}