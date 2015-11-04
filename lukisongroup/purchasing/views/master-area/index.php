<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'Master Area';
//$this->params['breadcrumbs'][] = $this->title;
$script = <<<SKRIPT

$(document).on('submit', 'form[data-pjax]', function(event) {
  $.pjax.submit(event, '#PtlCommentsPjax')
})

SKRIPT;

$this->registerJs($script);

?>
<div class="master-area-index">

    <h1><center><?= Html::encode($this->title) ?></center></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php Pjax::begin(['id'=>'PtlCommentsPjax'])?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'AreaID',
            'Description',
        ],
    ]); ?>
    <?php Pjax::end(); ?> 
    
        <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>        
        
</div>
