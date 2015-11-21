<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\hrd\organisasi */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Organisasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$sts = $model->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}
        
        if($model->image == null)
			{ 			
				$gmbr = "df.jpg";

			} 
			else { 
				
				$gmbr = $model->image;

				 }   
        
?>
<div class="organisasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!--Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>-->
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent',
            'title',
            'description',
            'phone',
            'email:email',
              [
				
               'attribute' => 'photo',
              'value'=>Yii::$app->urlManager->baseUrl.'/upload/image/'.$gmbr,
			'format' => ['image',['width'=>'150','height'=>'150']],
            ],  
           
            'itemType',
        ],
    ]) ?>

</div>
