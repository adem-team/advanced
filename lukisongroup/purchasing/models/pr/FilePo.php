<?php

namespace lukisongroup\purchasing\models\pr;

use Yii;


/**
 * This is the model class for table "p0001_file".
 *
 * @property integer $ID
 * @property integer $KD_PO
 * @property integer $IMG_BASE64
 */
class FilePo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'p0001_file';
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
            [['KD_PO'], 'required'],
            [['ID'], 'integer'],
            [['KD_PO'], 'string'],
			      [['IMG_BASE64'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_PO' => 'Kode PO',
            'IMG_BASE64' => 'Image',
        ];
    }
}
