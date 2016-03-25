<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Absensi */

$this->title = Yii::t('app', 'Create Absensi');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Absensis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="absensi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
