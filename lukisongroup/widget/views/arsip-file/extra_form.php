<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model dpodium\filemanager\models\Folders */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="folders-form">

    <?php

    // echo $form->field($node, 'path')->textInput(['maxlength' => true]);

    echo FileInput::widget([
    'name' => 'attachment_48[]',
    'options'=>[
        'multiple'=>true
    ],
    'pluginOptions' => [
        'uploadUrl' => Url::to(['/site/file-upload']),
        'uploadExtraData' => [
            'album_id' => 20,
            'cat_id' => 'Nature'
        ],
        'maxFileCount' => 10
    ]
]);
    ?>

</div>

