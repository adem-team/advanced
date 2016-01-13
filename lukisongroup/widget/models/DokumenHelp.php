<?php
namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;

/**
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
 */
class DokumenHelp extends Model
{
    public $ID;
    public $LINK;
	public $NAME;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [						
			[['ID','NAME','LINK'], 'string']		
        ];
    }
}
