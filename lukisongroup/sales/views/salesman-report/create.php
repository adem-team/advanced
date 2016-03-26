<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\SecheduleHeader */

$this->title = Yii::t('app', 'Create Sechedule Header');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sechedule Headers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sechedule-header-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
