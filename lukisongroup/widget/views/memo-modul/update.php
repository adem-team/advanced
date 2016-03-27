<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\MemoModul */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Memo Modul',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Memo Moduls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="memo-modul-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
