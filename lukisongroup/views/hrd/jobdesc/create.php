<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\Jobdesc */

$this->title = 'Create Jobdesc';
$this->params['breadcrumbs'][] = ['label' => 'Jobdescs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobdesc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
