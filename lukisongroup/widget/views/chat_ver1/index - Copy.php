<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
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

	
<?php

	
   /*GROUP CHART*/
   $ChatUserGroup=$this->render('_chat_group_info'); 
   $gv_ChatGroup= GridView::widget([    
        'id'=>'gv-chat-grp',
        'dataProvider' => $dataprovider1,
        //'filterModel' => $searchmodel1,			  
	    'columns' => [            	  
			['class' => 'yii\grid\ActionColumn', 
				'template' => '{view}',
				// 'contentOptions'=>[
					// 'style'=>'width:200px'
				// ],
				'header'=>$ChatUserGroup,				
				'buttons' => [
					'view'=>function($url, $model, $key){
						$name1 = $model->GROUP_NM;
						$icon1 = '<span class="glyphicon glyphicon-user"></span>';
						return Html::a($icon1.' '.$name1,
							['createajax','id'=>$model->GROUP_ID],
							[   
								'data-toggle'=>"modal",
								'data-target'=>"#modal-bumum",													
								//                                                                            'data-title'=> $model->username,
							]
						);
					},
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border'=>'0px',
					]
				],
			], 	
			[
                'label'=>'',
                'attribute'=>'GROUP_NM',
                'format' => 'raw',
                // 'value' => function($model){
						// $user = $model->GROUP_NM;
						//$icon1= '<span class="glyphicon glyphicon-user"></span>';
                    // return Html::button($user.''.$icon1,
                                
                                 // [     
                                       // 'class' => 'btn btn-default',
                                       // 'id'=>'mod1',
                                       // 'value' => $model->GROUP_ID,
                                       // 'data-toggle'=>"modal",
                                       // 'data-target'=>"#mymodal",													

				// ]);
                            
                          
                // }
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border'=>'0px',
					]
				],
            ], 
		],        
		'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat-grp',                
               ],
        ],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>false,
		'striped'=>false,
		//'autoXlFormat'=>true,
		
    ]);
	
	/* USER */
	$ChatUserInfo=$this->render('_chat_user_info'); 
	$gv_ChatUser = GridView::widget([    
        'id'=>'gv-chat-user',
        'dataProvider' => $dataProvider1,
		//'filterModel' => $searchModel,		
	    'columns' => [               
			/*[
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
				'header'=>$ChatUserInfo,
				'buttons' => [
					'view'=>function($url, $model, $key){
						$name = $model->username;
						$icon = '<span class="glyphicon glyphicon-user"></span>';
						return Html::a($icon.''.$name,
							['createajax','id'=>$model->id],
							[   
							'data-toggle'=>"modal",
							'data-target'=>"#modal-bumum",													
							//data-title'=> $model->username,
							]
						);
					},
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border'=>'0px',
					]
				],
			],
		],        
		'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat-user',                
               ],
        ],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>false,
		'striped'=>false,
		
    ]);
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="http://lukisongroup.com/widget/bootstrap-chat/assets/css/bootstrap.css" rel="stylesheet" />

</head>	
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">		
		<div class="col-md-4">
			 <div class="panel panel-success">
				<div class="panel-heading">
					GROUP CHAT
				</div>
				<div class="pre-scrollableRooms	 panel-body" id="room"  >
					<div  class="row">
						<?php
							echo $gv_ChatGroup;
						?>
					</div>
				</div>
			</div>
			 <div class="panel panel-info">
				<div class="panel-heading">
					ONLINE USERS		
				</div>
				<div class="pre-scrollableUser panel-body" id="room" >
					<div  class="row">
						<?php
							echo $gv_ChatUser;
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<?php
				echo Html::panel(
					[
						'heading' => "BERITA ACARA ",
						'body'=>$gv_Chat,
					],
					Html::TYPE_INFO
				);
			?>
		</div>
	</div> 
</div>	
	
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
 

 