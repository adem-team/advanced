<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Absensi */
/* @var $form yii\widgets\ActiveForm */
?>


<?php 
	//echo "test";
	echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'MODUL_NM',
            'MODUL_NM',
            'MODUL_NM',
            'MODUL_NM',
            'MODUL_NM',
            // 'TerminalID',
            // 'UserID',
            // 'FunctionKey',
            // 'Edited',
            // 'UserName',
            // 'FlagAbsence',
            // 'DateTime',
            // 'tgl',
            // 'waktu',
        ],
    ]);
?>
