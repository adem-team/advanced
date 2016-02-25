<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Personallog_usb */

$this->title = 'Create Personallog Usb';
$this->params['breadcrumbs'][] = ['label' => 'Personallog Usbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personallog-usb-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
