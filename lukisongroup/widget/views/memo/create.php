<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Memo */

$this->title = Yii::t('app', 'Create Memo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Memos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
