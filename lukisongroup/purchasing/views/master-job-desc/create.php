<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterJobDesc */

$this->title = 'Insert Master Job Desc';
//$this->params['breadcrumbs'][] = ['label' => 'Master Job Descs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-job-desc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
