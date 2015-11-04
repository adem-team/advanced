<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\maxi\Maxiprodak */

//$this->title = Yii::t('app', 'Update {modelClass}: ', [
//    'modelClass' => 'Maxiprodak',
//]) . ' ' . $model->EMP_ID;
/* add Menu Author: -ptr.nov-*/
$this->sideMenu = 'admin';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maxiprodaks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EMP_ID, 'url' => ['view', 'id' => $model->BRG_ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="maxiprodak-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
