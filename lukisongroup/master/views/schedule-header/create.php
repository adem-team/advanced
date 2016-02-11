<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Scheduleheader */

$this->title = 'Create Scheduleheader';
$this->params['breadcrumbs'][] = ['label' => 'Scheduleheaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduleheader-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
