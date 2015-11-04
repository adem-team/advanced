<?php

namespace lukisongroup\models\widget\doc;

use Yii;

/**
 * This is the model class for table "dba0001".
 *
 * @property string $ID
 * @property string $PARENT
 * @property string $MDL_ID
 * @property string $MDL_NM
 * @property string $MDL_DB
 * @property string $MDL_DB_ALIAS
 * @property string $MDL_TBL
 * @property string $MDL_KEY
 * @property string $MDL_FLD
 * @property string $MDL_CLS
 * @property string $MDL_LINK
 * @property string $DSCRP
 * @property string $CREATED_DATE
 * @property integer $STATUS
 * @property string $CORP_ID
 * @property string $DEP_ID
 * @property string $USER_CREATED
 * @property string $SORT
 */
class Docdba extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dba0001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PARENT', 'STATUS', 'USER_CREATED', 'SORT'], 'integer'],
            [['MDL_ID'], 'required'],
            [['DSCRP'], 'string'],
            [['CREATED_DATE'], 'safe'],
            [['MDL_ID', 'MDL_DB', 'MDL_DB_ALIAS', 'MDL_TBL'], 'string', 'max' => 20],
            [['MDL_NM', 'MDL_FLD', 'MDL_CLS', 'MDL_LINK'], 'string', 'max' => 255],
            [['MDL_KEY'], 'string', 'max' => 100],
            [['CORP_ID', 'DEP_ID'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARENT' => 'Parent',
            'MDL_ID' => 'Mdl  ID',
            'MDL_NM' => 'Nama Modul',
            'MDL_DB' => 'Database',
            'MDL_DB_ALIAS' => 'Database Alias',
            'MDL_TBL' => 'Table',
            'MDL_KEY' => 'Field Key',
            'MDL_FLD' => 'Table Field',
            'MDL_CLS' => 'Class Modul',
            'MDL_LINK' => 'Link',
            'DSCRP' => 'Dscrp',
            'CREATED_DATE' => 'Created  Date',
            'STATUS' => 'Status',
            'CORP_ID' => 'Corp  ID',
            'DEP_ID' => 'Dep  ID',
            'USER_CREATED' => 'User  Created',
            'SORT' => 'Sort',
        ];
    }

    /**
     * @inheritdoc
     * @return Dba0001Query the active query used by this AR class.
     */
    public static function find()
    {
        return new Dba0001Query(get_called_class());
    }
}
