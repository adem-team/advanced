<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\DailyJobModul */

$this->title = Yii::t('app', 'Create Daily Job Modul');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daily Job Moduls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daily-job-modul-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
