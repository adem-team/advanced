<?php

namespace lukisongroup\widget\models;

use Yii;
use lukisongroup\hrd\models\Employe;

/**
 * This is the model class for table "bt0003".
 *
 * @property integer $ID
 * @property string $KD_BERITA
 * @property integer $ID_USER
 * @property string $CHAT
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Commentberita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bt0003';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    public function getProfile()
    {
        return $this->hasOne(Employe::className(), ['EMP_ID' => 'ID_USER']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CHAT'], 'required'],
            [['STATUS'], 'integer'],
            [['CHAT','ID_USER'], 'string'],
            [['CREATED_AT', 'UPDATED_AT','EMP_IMG'], 'safe'],
            [['KD_BERITA'], 'string', 'max' => 20],
            [['CREATED_BY'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_BERITA' => 'Kd  Berita',
            'ID_USER' => 'Id  User',
            'CHAT' => 'Chat',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
        ];
    }
}
