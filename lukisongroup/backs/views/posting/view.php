<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\backs\models\Posting */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Postings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posting-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'PARENT',
            'JUDUL',

      (strip_tags('RESUME_EN:ntext'),
            
            'RESUME_ID:ntext',
            'IMG',
            'CREATEBY',
            'UPDATEBY',
        ],
    ]) ?>

</div>
