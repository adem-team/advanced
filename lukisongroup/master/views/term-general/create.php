<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termgeneral */

$this->title = 'Create Termgeneral';
$this->params['breadcrumbs'][] = ['label' => 'Termgenerals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="termgeneral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
