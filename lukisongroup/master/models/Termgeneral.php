<?php

namespace lukisongroup\master\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "c0004".
 *
 * @property integer $ID
 * @property string $SUBJECT
 * @property string $ISI_TERM
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Termgeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
public $image;
    public static function tableName()
    {
        return 'c0004';
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
            // [['ISI_TERM','SUBJECT'], 'required'],
               [['image'], 'file'],
            // [['ISI_TERM'], 'safe'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT','ISI_TERM'], 'safe'],
            [['SUBJECT'], 'string', 'max' => 255],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

    public function data($data,$to,$from)
    {
      # code...
      return ArrayHelper::map($data, $to, $from);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'SUBJECT' => 'Subject',
            'ISI_TERM' => 'Isi  Term',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
