<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\doc\Docdba */

$this->title = 'Create Docdba';
$this->params['breadcrumbs'][] = ['label' => 'Docdbas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docdba-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
