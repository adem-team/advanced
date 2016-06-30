<?php

namespace crm\export;

/**
 * export module definition class
 */
class Modul extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'crm\export\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
