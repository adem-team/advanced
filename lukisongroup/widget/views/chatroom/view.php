<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Chatroom */

$this->title = $model->GROUP_NM;
$this->params['breadcrumbs'][] = ['label' => 'Chatrooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;




?>
<div class="chatroom-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        
            'GROUP_NM',
        ],
    ]) ?>

</div>
