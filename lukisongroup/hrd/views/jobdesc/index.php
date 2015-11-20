<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
//


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\hrd\models\JobdescSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobdescs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobdesc-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=\kartik\grid\GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
        
            'JOBSDESK_TITLE',
            'JOBGRADE_NM',
            'JOBGRADE_DCRP:ntext',
            'JOBGRADE_STS',
			   [
				
               'attribute' => 'JOBSDESK_IMG',
               'format' => 'html',
               'value'=>function($data){
                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/image/' . $data-> JOBSDESK_IMG, ['width'=>'100']);
                        },
            ],  
            
             'JOBSDESK_PATH',
             'SORT',
             'CORP_ID',
             'DEP_ID',
             'DEP_SUB_ID',
             'GF_ID',
             'SEQ_ID',
             'JOBGRADE_ID',
//         [
//				
//               'attribute' => 'image',
//               'format' => 'html',
//               'value'=>function($data){
//                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/hrd/orgimage/' . $data->image, ['width'=>'100']);
//                        },
//            ],  
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','id'=>$model->ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-view",
                                                                'data-title'=> $this->title,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
                                                                ['update','id'=>$model->ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#modal-form",
                                                                'data-title'=> $this->title,
                                                                ]);
                            },
                              
                ],
            ],
                                    ],
	 
			
        

    
    'panel'=>[
          
            'type' =>GridView::TYPE_SUCCESS,//TYPE_WARNING, //TYPE_DANGER, 
                                         //GridView::TYPE_SUCCESS,//GridView::TYPE_INFO, //TYPE_PRIMARY, TYPE_INFO
            //'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add', '#', ['class'=>'btn btn-success']) . ' ' .
                //Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary']) . ' ' .
            //    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete  ', '#', ['class'=>'btn btn-danger'])
			/*
			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
					['modelClass' => 'Employe',]),
					['create'], ['class' => 'btn btn-success']),
			*/
			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'organisasi',]),'/hrd/jobdesc/create',
                                                                [   'data-toggle'=>"modal",
                                                                    'data-target'=>"#modal-form",
                                                                    'class' => 'btn btn-success'
															
									])
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'active',
                //'formSelector'=>'ddd1',
                //'options'=>[
                //    'id'=>'active'
               // ],
        ],
        'hover'=>true, //cursor select
        'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>'4px',
        'autoXlFormat'=>true,
        'export'=>[//export like view grid --ptr.nov-
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],

    ],
       // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
       // 'containerOptions' => ['style' => 'overflow: auto'],
    //'persistResize'=>true,
        //'responsiveWrap'=>true,
        //'floatHeaderOptions'=>['scrollContainer'=>'25'],

    ]);?>
    
  

</div>

<?php
$this->registerJs("
 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#modal-form').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title') 
            var href = button.attr('href') 
            //modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);

$this->registerJs("
        $('#modal-view').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title') 
            var href = button.attr('href') 
            //modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);


?>
   
            <!--modal-->
            
               <?php
              
                Modal::begin([
                            'id' => 'modal-form',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4> ',
               
                                 
                             ]);
                
               
                Modal::end();
                
             
                  Modal::begin([
                            'id' => 'modal-view',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
              
                
                ?>
