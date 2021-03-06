<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\CustomerVisitImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Customer Visit Images');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-visit-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Customer Visit Image'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'ID_DETAIL',
            //'IMG_NM',
            [
				'attribute'=>'image',
				'format'=>'raw', 
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){
					
					$test1='data:image/jpeg;charset=utf-8;base64,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';
					
					//$imageData = base64_decode($model->IMG_DECODE);				
					//return '<img src="data:image/jpg;base64,'.$model->IMG_DECODE.'" alt="">';
					//$base64 = str_replace('data:image/jpg;charset=utf-8;base64,', '', $model->IMG_DECODE);
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model->IMG_DECODE_START;
					///$base64 = base64_decode($base64);
					//$base64 = str_replace(' ', '+', $base64);
					return Html::img($base64,['width'=>'40','height'=>'40','class'=>'img-circle']);
					//return '<img src='.$test1.'>';
				},
			
			],
            'STATUS',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
