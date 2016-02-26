<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Personallog_usb */

$this->title = 'Update Personallog Usb: ' . ' ' . $model->TerminalID;
$this->params['breadcrumbs'][] = ['label' => 'Personallog Usbs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TerminalID, 'url' => ['view', 'id' => $model->TerminalID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="personallog-usb-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
