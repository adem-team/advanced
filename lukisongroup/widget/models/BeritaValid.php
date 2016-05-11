<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "a1000".
 *
 * @property integer $ID
 * @property string $KD_BERITA
 * @property string $JUDUL
 * @property string $ISI
 * @property string $KD_CORP
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property string $DATA_PICT
 * @property string $DATA_FILE
 * @property integer $STATUS
 * @property string $CREATED_ATCREATED_BY
 * @property string $CREATED_BY
 * @property string $UPDATE_AT
 * @property string $DATA_ALL
 */
class BeritaValid extends Model
{
    /**
     * @inheritdoc
     */
    public $alluser;
    public function rules()
    {
        return [
          [['JUDUL'], 'required'
              ],
          [['JUDUL','USER_CC','KD_DEP'], 'required','when' => function ($attribute) {
              return $attribute->alluser == 0; },
              'whenClient' => "function (attribute, value) {
                alert('tes');
                  // return $(this).is(':checked') == '0';
              }"
              ],
            [['alluser'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'alluser'=>'',
            'ID' => 'ID',
            'KD_BERITA' => 'Kd  Berita',
            'JUDUL' => 'Judul',
            'ISI' => 'Isi',
            'KD_CORP' => 'Kd  Corp',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'DATA_PICT' => 'Data  Pict',
            'DATA_FILE' => 'Data  File',
            'STATUS' => 'Status',
            'CREATED_ATCREATED_BY' => 'Created  Atcreated  By',
            'CREATED_BY' => 'Created  By',
            'UPDATE_AT' => 'Update  At',
            'DATA_ALL' => 'Data  All',
        ];
    }
}
