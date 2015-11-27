<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\esm\models\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategori-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>
    
    </p>-->

   

</div>
<?php
$tabcrud = \kartik\grid\GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
            'CUST_KTG',
            'CUST_KTG_PARENT',
            'CUST_KTG_NM',
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','id'=> $model->CUST_KTG],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#org",
                                                                'data-title'=> $model->CUST_KTG_NM,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
                                                                ['update','id'=>$model->CUST_KTG],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#organ1",
                                                                'data-title'=> $model->CUST_KTG_NM,
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
			'before'=>
                                    Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create Parent ',
						['modelClass' => 'Kategori',]),'/esm/kategoricus/createparent',
                                                                [   
                                                                    'class' => 'btn btn-success'
															
									]),
                              
  
                              
                    
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

    ]);
                            
                            
 $tabcustomers = GridView::widget([
  'dataProvider' => $dataProvider1,
  'filterModel' => $searchModelcus,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
            'CUST_KD',
            'CUST_NM',
            'CUST_KTG', 
            'TLP1', 
            'TLP2', 
            'FAX', 
            'STT_TOKO', 
            'STATUS',
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','id'=> $model->CUST_KD],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#org",
                                                                'data-title'=> $model->CUST_KD,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
                                                                ['update','id'=>$model->CUST_KD],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#organ1",
                                                                'data-title'=> $model->CUST_KD,
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
						['modelClass' => 'organisasi',]),'/esm/kategoricus/createcustomers',
                                                                [  
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

    ]);
                            
    $items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Kategory ','content'=>$tabcrud,
			//'active'=>true,

		],
		
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Customers','content'=>  $tabcustomers,//$tab_profile,
		],
                [
			'label'=>'<i class="glyphicon glyphicon-home"></i> MAP'//$tab_profile,
		],
    ];

echo TabsX::widget([
		'id'=>'tab',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,

	]);
                            
                            ?>

