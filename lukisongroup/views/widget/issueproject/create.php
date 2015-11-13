<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Issueproject */

$this->title = 'Create Issueproject';
$this->params['breadcrumbs'][] = ['label' => 'Issueprojects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="issueproject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
