<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\NotulenModul */

$this->title = Yii::t('app', 'Create Notulen Modul');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notulen Moduls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notulen-modul-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
