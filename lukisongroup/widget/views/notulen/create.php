<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */

$this->title = Yii::t('app', 'Create Notulen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notulens'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notulen-create">

    <!-- <h1Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'data_modul'=>$data_modul,
        'data_emp'=>$data_emp
    ]) ?>

</div>
