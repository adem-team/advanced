<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallMemo */

$this->title = 'Create Customercall Memo';
$this->params['breadcrumbs'][] = ['label' => 'Customercall Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-memo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
