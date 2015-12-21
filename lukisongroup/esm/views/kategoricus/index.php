<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\esm\models\KategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Customers';
// $this->params['breadcrumbs'][] = $this->title;
// ?>
// <div class="kategori-index">

//     <h1><?= Html::encode($this->title) ?></h1>
//     <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

// <!--    <p>
    
//     </p>-->

   

// </div>
// <?php
// $tabparent = 
// \kartik\grid\GridView::widget([
//   'dataProvider' =>$dataProviderparent,
//   'filterModel' =>$searchModel,
//    'columns'=>[
//        ['class'=>'yii\grid\SerialColumn'],
       
// 		     'CUST_KTG_NM',
   
//      [ 'class' => 'yii\grid\ActionColumn',
//                 'template' => '{view}{update}',
//                         'header'=>'Action',
//                         'buttons' => [
//                             'view' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
//                                                                 ['viewkota','id'=> $model->CUST_KTG],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#viewparent",
//                                                                 'data-title'=> $model->CUST_KTG_NM,
//                                                                 ]);
//                             },
                               
//                              'update' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
//                                                                 ['updatekota','id'=>$model->CUST_KTG],[
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
// 						['modelClass' => 'Barangumum',]),'/esm/kategoricus/createparent',[
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
// $tabkota = 

// \kartik\grid\GridView::widget([
//   'dataProvider' => $dataproviderkota,
//   'filterModel' => $searchmodelkota,
//    'columns'=>[
//        ['class'=>'yii\grid\SerialColumn'],
       
//             'PROVINCE',
//             'TYPE',
//             'CITY_NAME',
   
//      [ 'class' => 'yii\grid\ActionColumn',
//                 'template' => '{view}{update}',
//                         'header'=>'Action',
//                         'buttons' => [
//                             'view' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
//                                                                 ['viewkota','id'=> $model->CITY_ID],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#view2",
//                                                                 'data-title'=> $model->PROVINCE,
//                                                                 ]);
//                             },
                               
//                              'update' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
//                                                                 ['updatekota','id'=>$model->CITY_ID],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#form2",
//                                                                 'data-title'=> $model->PROVINCE,
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
// 						['modelClass' => 'Barangumum',]),'/esm/kategoricus/create',[
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
//                 'id'=>'active1',
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

// $tabprovince = \kartik\grid\GridView::widget([
//   'dataProvider' => $dataproviderpro,
//   'filterModel' => $searchmodelpro,
//    'columns'=>[
//        ['class'=>'yii\grid\SerialColumn'],
       
//              'PROVINCE',
   
//      [ 'class' => 'yii\grid\ActionColumn',
//                 'template' => '{view}{update}',
//                         'header'=>'Action',
//                         'buttons' => [
//                             'view' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
//                                                                 ['viewpro','id'=> $model->PROVINCE_ID],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#view3",
//                                                                 'data-title'=> $model->PROVINCE,
//                                                                 ]);
//                             },
                               
//                              'update' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
//                                                                 ['updatepro','id'=>$model->PROVINCE_ID],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#form3",
//                                                                 'data-title'=> $model->PROVINCE,
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
// 						['modelClass' => 'Barangumum',]),'/esm/kategoricus/createprovnce',[
// 							'data-toggle'=>"modal",
// 								'data-target'=>"#form3",
//                                     'id'=>'modl',
// 									'class' => 'btn btn-success'						
// 												]),
                              
  
                              
                    
//         ],
//         'pjax'=>true,
//         'pjaxSettings'=>[
//             'options'=>[
//                 'enablePushState'=>false,
//                 'id'=>'active2',
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

// ?>
// <?php
// $tabcrud = \kartik\grid\GridView::widget([
//   'dataProvider' => $dataProvider,
//   'filterModel' => $searchModel,
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
			
// 			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
// 					['modelClass' => 'Employe',]),
// 					['create'], ['class' => 'btn btn-success']),
			
// 			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
// 						['modelClass' => 'Barangumum',]),'/esm/kategoricus/create',[
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
//                 'id'=>'active3',
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
                            
                            
//  $tabcustomers = GridView::widget([
//   'dataProvider' => $dataProvider1,
//   'filterModel' => $searchModelcus,
//    'columns'=>[
//        ['class'=>'yii\grid\SerialColumn'],
       
//             'CUST_KD',
//             'CUST_NM',
//             'CUST_KTG', 
//             'TLP1', 
//             'TLP2', 
//             'FAX', 
//             'STT_TOKO', 
//             'STATUS',
   
//      [ 'class' => 'yii\grid\ActionColumn',
//                 'template' => '{view}{update}',
//                         'header'=>'Action',
//                         'buttons' => [
//                             'view' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
//                                                                 ['viewcust','id'=> $model->CUST_KD],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#view",
//                                                                 'data-title'=> $model->CUST_KD,
//                                                                 ]);
//                             },
                               
//                              'update' =>function($url, $model, $key){
//                                     return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
//                                                                 ['updatecus','id'=>$model->CUST_KD],[
//                                                                 'data-toggle'=>"modal",
//                                                                 'data-target'=>"#form",
//                                                                 'data-title'=> $model->CUST_KD,
//                                                                 ]);
//                             },
                              
//                 ],
//             ],
//                                     ],
                                    
                                    
	 
		
        

    
//    'panel'=>[
          
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
									
// 		'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
// 						['modelClass' => 'Barangumum',]),'/esm/kategoricus/createcustomers',[
// 							// 'data-toggle'=>"modal",
// 								// 'data-target'=>"#form",
//                                     // 'id'=>'modl2',
// 									'class' => 'btn btn-success'						
// 												]),
                              

                    
//         ],
//         'pjax'=>true,
//         'pjaxSettings'=>[
//             'options'=>[
//                 'enablePushState'=>false,
//                 'id'=>'active4',
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
                            
//     $items=[
// 		[
// 			'label'=>'<i class="glyphicon glyphicon-user"></i> New Customers ','content'=> $tabcustomers,
// 			//'active'=>true,

// 		],
		
// 		[
// 			'label'=>'<i class="glyphicon glyphicon-map-marker"></i> MAP'//$tab_profile,
// 		],
//                 [
// 			'label'=>'<i class="glyphicon glyphicon-folder-open"></i> DATA'//$tab_profile,
// 		],
// 			[
// 			'label'=>'<i class="glyphicon glyphicon-user"></i> Kategori Customers',//$tab_profile,
		
// 		        'items'=>[
//              [
//                  'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> PARENT',
//                  'encode'=>false,
//                  'content'=>$tabparent,
//                  // 'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=3'])]
//              ],
//              [
//                  'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> KATEGORI',
//                  'encode'=>false,
//                   'content'=>$tabcrud,
//                  // 'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=4'])]
//              ],
//         ],
// 		],
		
// 			[
// 			'label'=>'<i class="glyphicon glyphicon-globe"></i> Province ','content'=> $tabprovince//$tab_profile,
// 		],
// 				[
// 			'label'=>'<i class="glyphicon glyphicon-globe"></i> Kota','content'=>  $tabkota,//$tab_profile,
// 		],
//     ];

// echo TabsX::widget([
// 		'id'=>'tab',
// 		'items'=>$items,
// 		'position'=>TabsX::POS_ABOVE,
// 		//'height'=>'tab-height-xs',
// 		'bordered'=>true,
// 		'encodeLabels'=>false,
// 		//'align'=>TabsX::ALIGN_LEFT,

// 	]);
                            
//                             ?>
// 							<?php
							
// 									$this->registerJs("
//     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
//         $('#formparent').on('show.bs.modal', function (event) {
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

// $this->registerJs("
        
//         $('#viewparent').on('show.bs.modal', function (event) {
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
							
// 										$this->registerJs("
//     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
//         $('#form3').on('show.bs.modal', function (event) {
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

// $this->registerJs("
        
//         $('#view3').on('show.bs.modal', function (event) {
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
							
// 									$this->registerJs("
//     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
//         $('#form2').on('show.bs.modal', function (event) {
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

// $this->registerJs("
        
//         $('#view2').on('show.bs.modal', function (event) {
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
							
// 							$this->registerJs("
//     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
//         $('#form1').on('show.bs.modal', function (event) {
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

// $this->registerJs("
        
//         $('#view1').on('show.bs.modal', function (event) {
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
							
// $this->registerJs("
//     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
//         $('#form').on('show.bs.modal', function (event) {
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
	
// 	 Modal::begin([
//                             'id' => 'form3',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
                
//                  Modal::begin([
//                             'id' => 'view3',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
	
// 	 Modal::begin([
//                             'id' => 'form2',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
                
//                  Modal::begin([
//                             'id' => 'view2',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
				
	
// 	  Modal::begin([
//                             'id' => 'form',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
                
//                  Modal::begin([
//                             'id' => 'view',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
				
// 				 Modal::begin([
//                             'id' => 'form1',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
                
//                  Modal::begin([
//                             'id' => 'view1',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
				
// 				 Modal::begin([
//                             'id' => 'formparent',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();
                
//                  Modal::begin([
//                             'id' => 'viewparent',
//                             'header' => '<h4 class="modal-title">LukisonGroup</h4>',
//                              ]);
//                 Modal::end();



