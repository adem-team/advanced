<?php

use kartik\grid\GridView;
use yii\helpers\html;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;

	/*
	 * Jangan di Hapus ...
	 * Chat Menu Select Dashboard
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.0
	*/
	$this->sideMenu = $ctrl_chat!=''? $ctrl_chat:'mdefault';   


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\widget\models\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>

<!--message chat-->
<div class="col-sm-8">   
<?php      
  $gv_Chat = GridView::widget([
    
        'id'=>'gv-chat',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            
	    'columns' => [ 
                            [
                                'attribute' => 'MESSAGE',
                                'label' => 'Message',
                                'value' => function($model) { return $model->MESSAGE_ATTACH. " " . $model->MESSAGE ;},
                              ],
         	
                         ],
        
	'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat',                
               ],
        ],
			
		'panel'=>['type'=>'info', 'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-envelope"></i> Chat</h3>'],
		'hover'=>true, //cursor select
		'responsive'=>true,
		//'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		
    ])
    ?>
</div>
    
   

<!--chatting group-->

	<?php
    $gv_Chat1 = GridView::widget([
    
        'id'=>'gv-chat2',
        'dataProvider' => $dataprovider1,
          'filterModel' => $searchmodel1,		
	    'columns' => [
                
             /*     [
                'label'=>'GroupChat',
                'attribute'=>'GROUP_NM',
                'format' => 'raw',
                'value' => function($model){
						$user = $model->GROUP_NM;
						$icon1= '<span class="glyphicon glyphicon-user"></span>';
                    return Html::button($user.''.$icon1,
                                
                                 [     
                                       'class' => 'btn btn-default',
                                       'id'=>'mod1',
                                       'value' => $model->GROUP_ID,
                                       'data-toggle'=>"modal",
                                       'data-target'=>"#mymodal",													

				]);
                            
                          
                }
            ], */
			  
                ['class' => 'yii\grid\ActionColumn', 
					'template' => '{view}',
                                        'contentOptions'=>[
                                            'style'=>'width:200px'
                                        ],
					'header'=>'user',
					'buttons' => [
						'view'=>function($url, $model, $key){
								$name1 = $model->GROUP_NM;
								$icon1 = '<span class="glyphicon glyphicon-user"></span>';
								return Html::a($name1.''.$icon1,
                                                                       
                                                                    ['createajax','id'=>$model->GROUP_ID],
                                                                        [   
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-bumum",													
//                                                                            'data-title'=> $model->username,
									]
                                                                        
                                                                        
                                                                        );
                                                                },
                                                                        ],
                                                                        ],
                

         	
            ],
        
	'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat2',                
               ],
        ],
			
		'panel'=>['type'=>'info', 'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-user"></i> Rooms</h3>'],
		'hover'=>true, //cursor select
		'responsive'=>true,
		//'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		
    ])?>
	<?php
	
	// $waktu = time();
	// $datawaktu = Yii::$app->session['userSessionTimeout'];

	
	
	// if($datawaktu<$waktu)
	// {
		// $icon = "ofline";
	// }
	// else{
		// $icon = 'online';
	// }
	
	
	?>
          <?php 
		  $gv_Chat2 = GridView::widget([
    
        'id'=>'gv-chat1',
        'dataProvider' => $dataProvider1,
//        'filterModel' => $searchModel,		
	    'columns' => [
		
		
		
       
                
        /*     [
                'label'=>'User',
                 'attribute'=>'username',
                'format' => 'raw',
                'value' => function($model){
					$name = $model->username;
					$icon = '<span class="glyphicon glyphicon-user"></span>';
                    return Html::button($icon.''.$name,
                                
                                 [     
                                       'class' => 'btn btn-default',
                                       'id'=>'mod1',
                                       'value' => $model->id,
                                       'data-toggle'=>"modal",
                                       'data-target'=>"#mymodal",		
                                        
            ]);
			
				},
          
         	
            ], */
			     ['class' => 'yii\grid\ActionColumn', 
					'template' => '{view}',
                                        'contentOptions'=>[
                                            'style'=>'width:200px'
                                        ],
					'header'=>'user',
					'buttons' => [
						'view'=>function($url, $model, $key){
								$name = $model->username;
								$icon = '<span class="glyphicon glyphicon-user"></span>';
								return Html::a($icon.''.$name,
                                                                       
                                                                    ['createajax','id'=>$model->id],
                                                                        [   
                                                                            'data-toggle'=>"modal",
                                                                            'data-target'=>"#modal-bumum",													
//                                                                            'data-title'=> $model->username,
									]
                                                                        
                                                                        
                                                                        );
                                                                },
                                                                        ],
                                                                        ],
			],
        
	'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat1',                
               ],
        ],
			
		'panel'=>['type'=>'info', 'heading'=>'ONLINE USERS'],
		'hover'=>true, //cursor select
		'responsive'=>true,
		//'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		
    ])?>
	
	<?php
	$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-envelope"></i> Chatting',
        'content'=>$gv_Chat,
        'active'=>true
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-user"></i> GroupChat',
        'content'=>$gv_Chat1,
    ],
	 [
        'label'=>'<i class="glyphicon glyphicon-user"></i> ONLINE ',
        'content'=>$gv_Chat2,
    ],
	];
	
	?>
        
        <?php
        
       
        
      /*  $this->registerJs("
	    $('#tes').click(function(e) {
		 $.ajax({
       url: '/widget/chat/create',
       type: 'POST',
       data: {
              id: $('#mod1').val(),
			  mes: $('#mes').val()
             },
			async: false,
			dataType: 'json',
            success: function (result) {
                if(result == 1 )
                                          {
                                             $(document).find('#mymodal').modal('hide')
                                             $('#myform').trigger('reset');
                                             $.pjax.reload({container:'#gv-chat'});
                                          }
                                        else{
                                          
                                        }
            },
          
       
       });
	     e.preventDefault();
  });
  

        
        ",$this::POS_READY); */
                        

	
		
     
        ?>
    </div>
	<?php
	
	echo TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_RIGHT,
    'encodeLabels'=>false
]);
	
	?>
	
	<?php
	
	 $this->registerJs("
        
        $('#modal-bumum').on('show.bs.modal', function (event) {
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
	
	 Modal::begin([
                            'id' => 'modal-bumum',
                            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                             ]);
                Modal::end();
	
	?>


 

 