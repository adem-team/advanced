<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
//

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Jobdesc */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Jobdescs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobdesc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
      
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	
	<?php
	
		$sts = $model->STATUS;
	if($sts == 1){
		$stat = 'Aktif';
	} else {
		$stat = 'Tidak Aktif';
	}
	
	if($model->JOBSDESK_IMG == null)
			{ 			
				$gmbr = "df.jpg";

			} 
			else { 
				
				$gmbr = $model->JOBSDESK_IMG;

				 }  
	
	?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'ID',
            'JOBSDESK_TITLE',
            'JOBGRADE_NM',
            'JOBGRADE_DCRP:ntext',
            'JOBGRADE_STS',
            // 'JOBSDESK_IMG',
				[
				'attribute'=>'photo',
				// 'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->IMAGE,
				'value'=>Yii::$app->urlManager->baseUrl.'/upload/image/'.$gmbr,
				'format' => ['image',['width'=>'150','height'=>'150']],
			],
            'JOBSDESK_PATH',
            'SORT',
            'CORP_ID',
            'DEP_ID',
            'DEP_SUB_ID',
            'GF_ID',
            'SEQ_ID',
            'JOBGRADE_ID',
            'CREATED_BY',
            'UPDATED_BY',
            'UPDATED_TIME',
            'STATUS',
        ],
    ]) ?>

</div>
