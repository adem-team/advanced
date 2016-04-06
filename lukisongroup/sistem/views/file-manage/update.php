<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\FileManage */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'File Manage',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'File Manages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="file-manage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
