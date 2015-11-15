<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\Masterjadwalkerja */

$this->title = 'Import File';
//$this->params['breadcrumbs'][] = ['label' => 'Masterjadwalkerjas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterjadwalkerja-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
