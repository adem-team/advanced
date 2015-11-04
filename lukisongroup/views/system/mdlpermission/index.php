<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use lukisongroup\models\system\user\Userlogin;
use lukisongroup\models\system\erpmodul\Modulerp;
$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'LG - Administrator');         /* title pada header page */
$filter_Modulerp=ArrayHelper::map(Modulerp::find()->asArray()->all(), 'MODUL_ID','MODUL_NM');
?>
<div class="mdlpermission-index">

    <p>
        <?php 
			echo "Html::a('Create ERP Permission', ['create'], ['class' => 'btn btn-success'])";
			//echo "<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-lg">Launch demo modal</a>";
		
		?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			
            //'ID',
         	[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'USER_ID',
               'format' => 'html', 
               'value'=>function($model){
								$username=Userlogin::find()->where(['id'=>$model->USER_ID])->one();
								return Html::decode($username->username);
						},
				'filter' => ArrayHelper::map(Userlogin::find()->asArray()->all(), 'id','username'),
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'MODUL_ID',
               'format' => 'html', 
                'value'=>function($model){
								$MODUL_NM=Modulerp::find()->where(['MODUL_ID'=>$model->MODUL_ID])->one();
								return Html::decode($MODUL_NM->MODUL_NM);
						},
				'filter' => ArrayHelper::map(Modulerp::find()->asArray()->all(), 'MODUL_ID','MODUL_NM'),
            ],
            [
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'STATUS',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->STATUS == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->STATUS == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			 [
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_CREATE',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_CREATE == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_CREATE == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_EDIT',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_EDIT == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_EDIT == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_DELETE',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_DELETE == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_DELETE == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_VIEW',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_VIEW == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_VIEW == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_PROCESS1',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_PROCESS1 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_PROCESS1 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_PROCESS2',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_PROCESS2 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_PROCESS2 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_PROCESS3',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_PROCESS3 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_PROCESS3 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_PROCESS4',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_PROCESS4 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_PROCESS4 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],			
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_PROCESS5',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_PROCESS5 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_PROCESS5 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_SIGN1',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_SIGN1 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_SIGN1 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_SIGN2',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_SIGN2 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_SIGN2 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_SIGN3',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_SIGN3 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_SIGN3 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_SIGN4',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_SIGN4 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_SIGN4 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			[
			   //'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'BTN_SIGN5',
               'format' => 'html', 
               'value'=>function($model){
                           if ($model->BTN_SIGN5 == 0) {
								return Html::a('<i class="fa fa-lock"></i>');
							} else if ($model->BTN_SIGN5 == 1) {
								return Html::a('<i class="fa fa-unlock "></i>');
							} 
                        },
            ],
			['class' => 'yii\grid\ActionColumn',
				'urlCreator'=>function($action, $dataProvider, $key, $index) {
				if ($action === 'view')
					$url = Yii::$app->urlManager->createUrl('option?id='.$key.''); 
				else if ($action === 'update')
								$url = Yii::$app->urlManager->createUrl('question/update?id='.$key.''); 
				else if ($action === 'delete')
								$url = Yii::$app->urlManager->createUrl('question/delete?id='.$key.''); 
						return $url;
				},
				//'viewOptions'=>['title'=>'ok', 'data-toggle'=>'modal', 'data-target'=>'#userModal', 'data-pjax' => '0'],
			],
		],
    ]); 
	
	/*
	$js='$("#ro_permission_view").modal("show")';
	$this->registerJs($js);
	echo $this->render('_view', [
            'model' => $model,//->findModel($id),
        ]);
	
	*/
	?>
	
</div>
