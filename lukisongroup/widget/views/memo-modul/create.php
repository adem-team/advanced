<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\MemoModul */

$this->title = Yii::t('app', 'Create Memo Modul');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Memo Moduls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-modul-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
