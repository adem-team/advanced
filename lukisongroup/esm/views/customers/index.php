<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use lukisongroup\esm\models\Customers;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
MapAsset::register($this);  

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
// print_r($dataProviderparent );
// die();

// $tabparent = 
// \kartik\grid\GridView::widget([
//   'dataProvider' => $dataProviderkat ,
//    'filterModel' => $searchModel ,
//    'columns'=>[
//        ['class'=>'yii\grid\SerialColumn'],
       
// 		     'CUST_KTG_NM',
   
//      [ 'class' => 'yii\grid\ActionColumn',
//                 'template' => '{view}{update}',
//                         'header'=>'Action',
//                         'buttons' => [
//                             'view' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
//                                                                 ['viewparent','id'=> $model->CUST_KTG],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#viewparent",
//                                                                 'data-title'=> $model->CUST_KTG_NM,
//                                                                 ]);
//                             },
                               
//                              'update' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
//                                                                 ['updateparent','id'=>$model->CUST_KTG],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#formparent",
//                                                                 'data-title'=> $model->CUST_KTG_NM,
//                                                                 ]);
//                             },
                              
//                 ],
//             ],
//                                     ],
                                    
                                    
	 
		
        

    
//     'panel'=>[
          
//             'type' =>GridView::TYPE_SUCCESS,//TYPE_WARNING, //TYPE_DANGER, 
//                                          //GridView::TYPE_SUCCESS,//GridView::TYPE_INFO, //TYPE_PRIMARY, TYPE_INFO
//             //'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add', '#', ['class'=>'btn btn-success']) . ' ' .
//                 //Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary']) . ' ' .
//             //    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete  ', '#', ['class'=>'btn btn-danger'])
// 			/*
// 			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
// 					['modelClass' => 'Employe',]),
// 					['create'], ['class' => 'btn btn-success']),
// 			*/
// 			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
// 						['modelClass' => 'Barangumum',]),'/esm/customers/createparent',[
// 							'data-toggle'=>"modal",
// 								'data-target'=>"#formparent",
//                                     'id'=>'modlparent',
// 									'class' => 'btn btn-success'						
// 												]),
                              
  
                              
                    
//         ],
//         'pjax'=>true,
//         'pjaxSettings'=>[
//             'options'=>[
//                 'enablePushState'=>false,
//                 'id'=>'active8',
//                 //'formSelector'=>'ddd1',
//                 //'options'=>[
//                 //    'id'=>'active'
//                // ],
//         ],
//         'hover'=>true, //cursor select
//         'responsive'=>true,
//         'responsiveWrap'=>true,
//         'bordered'=>true,
//         'striped'=>'4px',
//         'autoXlFormat'=>true,
//         'export'=>[//export like view grid --ptr.nov-
//             'fontAwesome'=>true,
//             'showConfirmAlert'=>false,
//             'target'=>GridView::TARGET_BLANK
//         ],

//     ],
//        // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
//        // 'containerOptions' => ['style' => 'overflow: auto'],
//     //'persistResize'=>true,
//         //'responsiveWrap'=>true,
//         //'floatHeaderOptions'=>['scrollContainer'=>'25'],

//     ]);

$tabkota = 

\kartik\grid\GridView::widget([
  'dataProvider' => $dataproviderkota,
  'filterModel' => $searchmodelkota,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
            'PROVINCE',
            'TYPE',
            'CITY_NAME',
            'POSTAL_CODE',
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['viewkota','id'=> $model->CITY_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#view2",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
                                                                ['updatekota','id'=>$model->CITY_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#form2",
                                                                'data-title'=> $model->PROVINCE,
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
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/esm/customers/createkota',[
							'data-toggle'=>"modal",
								'data-target'=>"#form1",
                                    'id'=>'modl',
									'class' => 'btn btn-success'						
												]),
                              
  
                              
                    
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'xactive20',
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



$tabprovince = \kartik\grid\GridView::widget([
  'dataProvider' => $dataproviderpro,
  'filterModel' => $searchmodelpro,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
             'PROVINCE',
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['viewpro','id'=> $model->PROVINCE_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#view3",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
                                                                ['updatepro','id'=>$model->PROVINCE_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#form3",
                                                                'data-title'=> $model->PROVINCE,
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
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/esm/customers/createprovnce',[
							'data-toggle'=>"modal",
								'data-target'=>"#form3",
                                    'id'=>'modl22',
									'class' => 'btn btn-success'						
												]),
                              
  
                              
                    
        ],
         'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'active209',
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

?>


<!-- grid kategori customers -->
<?php


$tabcrud =  GridView::widget([
    'id'=>'activeax127',
    'dataProvider'=>$dataProviderkat,
    'filterModel'=>$searchModel,
    //'showPageSummary'=>true,
    // 'pjax'=>true,
    // 'striped'=>true,
    // 'hover'=>true,
    //'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],

          
     
        
        [               
                    'label'=>'Group',
                    'attribute' =>'PRN_NM',
                   // 'filter' => ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_NM','SEQ_NM'),
                    'group'=>true,
                ],      
         [
           'label' =>'Customers kategori',
            'attribute' =>'customers_Kategori',
          
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(Kategoricus::find()->orderBy('CUST_KTG_NM')->asArray()->all(), 'id', 'category_name'), 
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Any category'],
             'group'=>true,  // enable grouping
             'subGroupOf'=>4 // supplier column index is the parent group
        ],
        

        [   
                    'class' => 'yii\grid\ActionColumn', 
                    'template' => ' {edit} {view}',
                    'header'=>'Action',
                    'buttons' => [

                         'edit' =>function($url, $model, $key){
                                return  Html::a('<span class="glyphicon glyphicon-plus"></span>',['create','id'=> $model->CUST_KTGB],[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'data-title'=> $model->CUST_KTG_NM,
                                                            ]);
                        },

                        'view' =>function($url, $model, $key){
                                return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$model->CUS_ID],[
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#viewparent",
                                                            'data-title'=> $model->CUST_KTG,
                                                            ]);
                        },
                        
                      
                        
                    ],

                ],

          
       
    ],

'panel'=>[
                //'heading' =>true,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
                'type' =>GridView::TYPE_SUCCESS,
                /*
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
                        ['modelClass' => 'Employe',]),
                        ['create'], ['class' => 'btn btn-success']),
                        [
                */
                /*Create Controller renderAjax*/
                /* harus path /hrd/jobgrademodul/create' -> index case error*/
                'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create Parent ',
                        ['modelClass' => 'Kategoricus',]),'/esm/customers/createparent',[  
                                                            'data-toggle'=>"modal",
                                                            'data-target'=>"#formparent",
                                                            'class' => 'btn btn-success'
                                                            ])
            ],
            'pjax'=>true,
            'pjaxSettings'=>[
                'options'=>[
                    'enablePushState'=>false,
                    'id'=>'activeax127',
                ],
            ],
            'hover'=>true, //cursor select
            //'responsive'=>true,
            'responsiveWrap'=>true,
            'bordered'=>true,
            'striped'=>'4px',
            'autoXlFormat'=>true,
            'export'=>[//export like view grid --ptr.nov-
                'fontAwesome'=>true,
                'showConfirmAlert'=>false,
                'target'=>GridView::TARGET_BLANK
            ],
        ]); 

// <!-- kategori  -->


// $tabcrud = \kartik\grid\GridView::widget([
//   'dataProvider' => $dataProviderkat,
//   'filterModel' =>   $searchModel,
//    'columns'=>[
//        ['class'=>'yii\grid\SerialColumn'],
       
//             // 'CUST_KTG',
//             // 'CUST_KTG_PARENT',
//             'CUST_KTG_NM',
   
//      [ 'class' => 'yii\grid\ActionColumn',
//                 'template' => '{view}{update}',
//                         'header'=>'Action',
//                         'buttons' => [
//                             'view' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
//                                                                 ['view','id'=> $model->CUST_KTG],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#view1",
//                                                                 'data-title'=> $model->CUST_KTG_NM,
//                                                                 ]);
//                             },
                               
//                              'update' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
//                                                                 ['update','id'=>$model->CUST_KTG],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#form1",
//                                                                 'data-title'=> $model->CUST_KTG_NM,
//                                                                 ]);
//                             },
                              
//                 ],
//             ],
//                                     ],
                                    
                                    
	 
		
        

    
//     'panel'=>[
          
//             'type' =>GridView::TYPE_SUCCESS,//TYPE_WARNING, //TYPE_DANGER, 
//                                          //GridView::TYPE_SUCCESS,//GridView::TYPE_INFO, //TYPE_PRIMARY, TYPE_INFO
//             //'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add', '#', ['class'=>'btn btn-success']) . ' ' .
//                 //Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary']) . ' ' .
//             //    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete  ', '#', ['class'=>'btn btn-danger'])
// 			/*
// 			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
// 					['modelClass' => 'Employe',]),
// 					['create'], ['class' => 'btn btn-success']),
// 			*/
// 			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
// 						['modelClass' => 'Barangumum',]),'/esm/customers/create',[
// 							'data-toggle'=>"modal",
// 								'data-target'=>"#form1",
//                                     'id'=>'modl',
// 									'class' => 'btn btn-success'						
// 												]),
                              
  
                              
                    
//         ],
//         'pjax'=>true,
//         'pjaxSettings'=>[
//             'options'=>[
//                 'enablePushState'=>false,
//                 'id'=>'dsactive3',
//                 //'formSelector'=>'ddd1',
//                 //'options'=>[
//                 //    'id'=>'active'
//                // ],
//         ],
//         'hover'=>true, //cursor select
//         'responsive'=>true,
//         'responsiveWrap'=>true,
//         'bordered'=>true,
//         'striped'=>'4px',
//         'autoXlFormat'=>true,
//         'export'=>[//export like view grid --ptr.nov-
//             'fontAwesome'=>true,
//             'showConfirmAlert'=>false,
//             'target'=>GridView::TARGET_BLANK
//         ],

//     ],
//        // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
//        // 'containerOptions' => ['style' => 'overflow: auto'],
//     //'persistResize'=>true,
//         //'responsiveWrap'=>true,
//         //'floatHeaderOptions'=>['scrollContainer'=>'25'],

//     ]);
           // print_r($searchparent);
           // die();                 
                            
 $tabcustomers = GridView::widget([
     // 'id'=>'axctive224',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel ,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
            'CUST_KD',
             [
                'class'=>'kartik\grid\EditableColumn',
                'attribute' => 'CUST_KD_ALIAS'
            ],    
             
            'CUST_NM',
             [
                'label'=>'Customer Kategori',
                'attribute' =>'cus.CUST_KTG_NM',
               // 'filter' => $Combo_Dept,
            ],
            
            // 'CUST_KTG', 
            'TLP1', 
            'TLP2', 
            'FAX',
             'ALAMAT',
             'JOIN_DATE',
             'EMAIL',
             'WEBSITE',
            // 'STT_TOKO',
             [   
                'label' =>'Status Toko',
                'value' => function ($model) {
                    if ($model->STATUS == 1) {
                        return 'Hak Milik';
                    } else if ($model->STATUS == 0) {
                        return 'Sewa';
                    } 
                },

            ], 
            // 'STATUS',
            [

                'format' => 'raw',
                'label'=> 'Status Customers',
                'value' => function ($model) {
                    if ($model->STATUS == 1) {
                        return '<i class="fa fa-check fa-lg ya" style="color:blue;" title="Aktif">aktif</i>';
                    } else if ($model->STATUS == 0) {
                        return '<i class="fa fa-times fa-lg no" style="color:red;" title="Tidak Aktif" >Tidak Aktif</i>';
                    } 
                },
            ], 
                
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<span class="glyphicon glyphicon-eye-open"></span> ',
                                                                ['viewcust','id'=> $model->CUST_KD],[
                                                                // 'data-toggle'=>"modal",
                                                                // 'data-target'=>"#view",
                                                                // 'data-title'=> $model->CUST_KD,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<span class="glyphicon glyphicon-user"></span>   
                                                                ',
                                                                ['updatecus','id'=>$model->CUST_KD],[
                                                                // 'data-toggle'=>"modal",
                                                                // 'data-target'=>"#form",
                                                                // 'data-title'=> $model->CUST_KD,
                                                                ]);
                            },

                            
                              'delete' =>function($url, $model, $key){
                                    return  Html::a('<i class="glyphicon glyphicon-trash"></i>',
                                                                ['deletecus','id'=>$model->CUST_KD],[
                                                                // 'data-toggle'=>"modal",
                                                                // 'data-target'=>"#form",
                                                                // 'data-title'=> $model->CUST_KD,
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
									
		'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/esm/customers/createcustomers',[
							// 'data-toggle'=>"modal",
							// 	'data-target'=>"#form",
       //                              'id'=>'modl2',
									'class' => 'btn btn-success'						
												]),
                              

                    
        ],
         'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'axctive224',
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
  
 
          $map = '<div id ="map" style="width:100%;height:400px"></div>';    
                 
    $items=[
		[
			'label'=>'<i class="glyphicon glyphicon-user"></i> New Customers ','content'=> $tabcustomers, //   $tabcustomers,
		   

		],
		
		[
			'label'=>'<i class="glyphicon glyphicon-map-marker"></i> MAP','content'=> $map, //$tab_profile,
             'active'=>true,
		],
        [
			'label'=>'<i class="glyphicon glyphicon-folder-open"></i> DATA',//'content'=>$tabparent,//$tab_profile,
		],
			[
			'label'=>'<i class="glyphicon glyphicon-user"></i> Kategori Customers','content'=>$tabcrud,
		
		   
		],
		
			[
			'label'=>'<i class="glyphicon glyphicon-globe"></i> Province ','content'=> $tabprovince//$tab_profile,
		],
				[
			'label'=>'<i class="glyphicon glyphicon-globe"></i> KOTA',
            
            //'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/esm/customers/maptampil'])]
            'content'=>$tabkota,//$tab_profile,
           
		],
    ];

    

echo TabsX::widget([
		'id'=>'tab1',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,

	]);
            ?>
							
           
              
                        <?php

$this->registerJs("
     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#form3').on('show.bs.modal', function (event) {
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
        
        $('#view3').on('show.bs.modal', function (event) {
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
    ",$this::POS_LOAD);        
		


							
    $this->registerJs("
    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#formparent').on('show.bs.modal', function (event) {
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
        
        $('#viewparent').on('show.bs.modal', function (event) {
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
    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#form2').on('show.bs.modal', function (event) {
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
         $('#view2').on('show.bs.modal', function (event) {
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
      
    $.fn.modal.Constructor.prototype.enforceFocus = function(){};

        $('#form1').on('show.bs.modal', function (event) {
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
        
        $('#view1').on('show.bs.modal', function (event) {
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

    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
       
        $('#form').on('show.bs.modal', function (event) {

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

    ",$this::POS_LOAD);

// $this->registerJs("
        
//         $('#view').on('show.bs.modal', function (event) {
//             var button = $(event.relatedTarget)
//             var modal = $(this)
//             var title = button.data('title') 
//             var href = button.attr('href') 
//             //modal.find('.modal-title').html(title)
//             modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
//             $.post(href)
//                 .done(function( data ) {
//                     modal.find('.modal-body').html(data)
//                 });
//             })
//     ",$this::POS_READY);
	
	 Modal::begin([
                            'id' => 'form3',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                 Modal::begin([
                            'id' => 'view3',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
	
	 Modal::begin([
                            'id' => 'form2',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                 Modal::begin([
                            'id' => 'view2',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
				
	
	  Modal::begin([
                            'id' => 'form',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                 Modal::begin([
                            'id' => 'view',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
				
				 Modal::begin([
                            'id' => 'form1',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                 Modal::begin([
                            'id' => 'view1',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
				
				 Modal::begin([
                            'id' => 'formparent',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
                
                 Modal::begin([
                            'id' => 'viewparent',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();

$this->registerJs("
//nampilin MAP
 var map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 12,
        center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
        mapTypeId: google.maps.MapTypeId.ROADMAP

    });


        
    var public_markers = [];
    var infowindow = new google.maps.InfoWindow();

//data
 $.getJSON('/esm/customers/map', function(json) { 

    for (var i in public_markers)
    {
        public_markers[i].setMap(null);
    }

    $.each(json, function (i, point) {
        // alert(point.MAP_LAT);
 
//set the icon 
//     if(point.CUST_NM == 'asep')
//         {
//             icon = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
//         }

            var marker = new google.maps.Marker({
            // icon: icon,
            position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
            animation:google.maps.Animation.BOUNCE,
            map: map,
             icon : 'http://labs.google.com/ridefinder/images/mm_20_red.png'
        });

         public_markers[i] = marker;

         google.maps.event.addListener(public_markers[i], 'mouseover', function () {
             infowindow.setContent('<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>');
             infowindow.open(map, public_markers[i]);
         });


    });

 
 });
    
    // console.trace();

     ",$this::POS_READY);
