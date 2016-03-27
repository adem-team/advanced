<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\DailyJob */

$this->title = Yii::t('app', 'Create Daily Job');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daily Jobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="daily-job-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
