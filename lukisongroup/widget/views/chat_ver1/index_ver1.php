<?php

/* extensions*/
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* namespace models*/
use lukisongroup\hrd\models\Employe;
use lukisongroup\widget\models\Chatroom;

	/*
	 * Jangan di Hapus ...
	 * Chat Menu Select Dashboard
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.0
	*/
	$this->sideMenu = $ctrl_chat!=''? $ctrl_chat:'mdefault';

?>

<div class="col-lg-12">
    <div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Simple Chat</h3>
        </div>
        <div class="box-body">
            <div class="direct-chat-messages" id="message-container">
            </div>
        </div>
        <div class="box-footer">
            <div class="input-group">
                <input type="text" id="inp-chat" placeholder="Type Message ..." class="form-control">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat" id="btn-chat">Send</button>
                </span>
            </div>
        </div>
    </div>
</div>
<?php


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\widget\models\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
  $profile = Yii::$app->getUserOpt->profile_user()->emp;

	/*message chat ver1*/
	$gv_Chat = GridView::widget([
        'id'=>'gv-chat-msg',
        'dataProvider' => $dataProviderMsg,
        //'filterModel' => $searchModelMsg,
	    'columns' => [
			[
				'attribute' => 'MESSAGE',
				'label' => '',
				'value' => function($model) { return $model->MESSAGE_ATTACH. " " . $model->MESSAGE ;},
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(199, 245, 24, 0.3)',
						'border'=>'0px',
					]
				],
			],
		],
		'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat-msg',
               ],
        ],
		//'panel'=>['type'=>'info', 'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-envelope"></i> Chat</h3>'],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>false,
		'striped'=>false,
    ]);

	/*message chat ve2*/
	$body1 = [];
 $profile->EMP_ID = 0;
    foreach ($dataProviderMsg->getModels() as $key => $value) {
      # code...
      if($value->employee->IMG_BASE64 == '')
      {
         $gambar_profile='/img_setting/noimage/df.jpg';
      }else {
        # code...
        	$gambar_profile = 'data:image/jpg;charset=utf-8;base64,'.$value->employee->IMG_BASE64;
      }

        /*default image*/

				

		if ($profile->EMP_ID == 0){
			$a=$this->render('_message_left', [
				'gambar'=>$gambar_profile,
				'nama'=>$value->employee->EMP_NM,
				// 'messageReply'=>$value->MESSAGE,
				'jamwaktu'=> date('Y-m-d h:i A', strtotime($value->UPDATED_TIME)),
			]);
		$profile->EMP_ID = 1;
		}else{
			$a=$this->render('_message_right', [
				'gambar'=>$gambar_profile,
				'nama'=>$value->employee->EMP_NM,
				// 'messageReply'=>$value->MESSAGE,
				'jamwaktu'=> date('Y-m-d h:i A', strtotime($value->UPDATED_TIME)),
			]);
		$profile->EMP_ID = 0;
		}

		$body .=$a;
    }
	$body1 [] = ['body'=>$body];



   /*GROUP CHART*/
   $ChatUserGroup=$this->render('_chat_group_info'); //Button reply, Back
   $gv_ChatGroup= GridView::widget([
        'id'=>'gv-chat-grp',
        'dataProvider' => $dataproviderGrp,
        //'filterModel' => $searchmodelGrp,
        'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
    		'rowOptions'   => function ($model, $key, $index, $grid) {
       			return ['id' => $model->ID,'onclick' =>'var group = "group"
                  $.pjax.reload({
            				url: "'.Url::to(['/widget/chat/index']).'?ChatSearch[GROUP]="+this.id+"&&chat="+group,
            				container: "#chat-msg",
            				timeout: 1000,
        			});'];
   },
	    'columns' => [
			[
                'attribute'=>'x',
				'format'=>'raw',
				'label'=>'',
				'value'=>function($model){
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model['IMAGE64'];
					$baseImge64=$model['IMAGE64']!=''?$base64:'/img_setting/noimage/df.jpg';
					return Html::img($baseImge64,['class'=>'contacts-list-img']);
				 },
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'10px',
						//'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'12pt',
						'background-color'=>'rgba(255, 255, 155, 0.3)',
						'border'=>'0px',
					]
				],
            ],
			['class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				// 'contentOptions'=>[
					// 'style'=>'width:200px'
				// ],
				//'header'=>$ChatUserGroup,
				'header'=>false,
				'buttons' => [
					'view'=>function($url, $model, $key){
						$name1 = $model->GROUP_NM;
						$icon1 = '<span class="glyphicon glyphicon-user"></span>';
						// return Html::a($name1,
						// 	['createajax','id'=>$model->GROUP_ID],
						// 	[
						// 		'data-toggle'=>"modal",
						// 		'data-target'=>"#modal-bumum",
						// 		//                                                                            'data-title'=> $model->username,
						// 	]
						// );
						return $name1;
					},
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						//'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(255, 255, 155, 0.3)',
						'border'=>'0px',
					]
				],
			],
			[
                'label'=>'',
                'attribute'=>'x',
                'format' => 'raw',
                'value' => function($model){
					$nilai="<span class='badge ' style='background-color:#2EC12E;font-size:8pt'>10 </span>";
					return $nilai;
				},
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'padding-right'=>'20px',
						//'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'background-color'=>'rgba(255, 255, 155, 0.3)',
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
        'dataProvider' => $dataProviderUser,
        'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
    		'rowOptions'   => function ($model, $key, $index, $grid) {
       			return ['id' => $model->EMP_ID,'onclick' =>'
                var user = "user";
                  $.pjax.reload({
            				url: "'.Url::to(['/widget/chat/index']).'?ChatSearch[GROUP]="+this.id+"&&chat="+user,
            				container: "#chat-msg",
            				timeout: 1000,
        			});'];
   },
	    'columns' => [
			[
                'attribute'=>'x',
				'format'=>'raw',
				'label'=>'',
				'value'=>function($model){

          $cari_employechat_image = Employe::find()->where(['EMP_ID'=>$model->EMP_ID])->one();
           $baseimage_64 = $cari_employechat_image->IMG_BASE64 !=''?'data:image/jpg;charset=utf-8;base64,'.$cari_employechat_image->IMG_BASE64:'/img_setting/noimage/df.jpg';
					
					return  Html::img($baseimage_64,['class'=>'contacts-list-img']);
				 },
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'10px',
						//'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'border'=>'0px',
						'background-color'=>'rgba(255, 255, 155, 0.3)'
					]
				],
            ],
			['class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				// 'contentOptions'=>[
					// 'style'=>'width:200px'
				// ],
				//'header'=>$ChatUserInfo,
				'header'=>false,
				'buttons' => [
					'view'=>function($url, $model, $key){
						$name = $model->username;
						$icon = '<span class="glyphicon glyphicon-user"></span>';
						//return Html::a($icon.''.$name,
						// return Html::a($name,
						// 	['createajax','id'=>$model->id],
						// 	[
						// 	'data-toggle'=>"modal",
						// 	'data-target'=>"#modal-bumum",
						// 	//data-title'=> $model->username,
						// 	]
						// );
						return $name;
					},
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border'=>'0px',
						'background-color'=>'rgba(255, 255, 155, 0.3)'
					]
				],
			],
			[
                'label'=>'',
                'attribute'=>'x',
                'format' => 'raw',
                'value' => function($model){
                  if($model->ONLINE == 1)
                  {
                    $onlineicon = 'Online <i class="fa fa-circle text-success"></i>';
                    return $onlineicon;
                  }else{
                    $oflineicon = 'Ofline <i class="fa fa-circle text-danger"></i>';
                    return $oflineicon;
                    // $nilai="<span class='badge ' style='background-color:#2EC12E;font-size:8pt'>10 </span>";
          					// return $nilai;
                  }

				},
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'padding-right'=>'20px',
						//'width'=>'10px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						'border'=>'0px',
						'background-color'=>'rgba(255, 255, 155, 0.3)'
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
		//

    ]);


?>

<?php
/* params */
$params = Yii::$app->request->queryParams;

/**
*if count params equal 0 then give user option
* @author : wawan
*/
if(count($params) == 0)
{
  $useavatar = Yii::$app->getUserOpt->profile_user()->emp;
  if($useavatar->IMG_BASE64)
  {
    $gambaravatar = '/img_setting/noimage/df.jpg';
    $nama = $useavatar->EMP_NM;
  }else {
    # code...
    $nama = $useavatar->EMP_NM;
    $gambaravatar = 'data:image/jpg;charset=utf-8;base64,'.$useavatar->IMG_BASE64;
  }

}elseif ($params['chat'] == 'group') {
  # code...
  $group_id = $params['ChatSearch']['GROUP'];
  $useavatar = Chatroom::find()->where(['GROUP_ID'=>$group_id])->one();
	$nama = $useavatar->GROUP_NM;
  $gambaravatar = 'data:image/jpg;charset=utf-8;base64,'.$useavatar->IMAGE64;
}else{
  $emp_chat_id = $params['ChatSearch']['GROUP'];
  $useavatar = Employe::find()->where(['EMP_ID'=>$emp_chat_id])->one();
  if($useavatar->IMG_BASE64 == '')
  {
      $nama = $useavatar->EMP_NM;
      $gambaravatar = '/img_setting/noimage/df.jpg';
  }else {
    # code...
    $nama = $useavatar->EMP_NM;
    $gambaravatar = 'data:image/jpg;charset=utf-8;base64,'.$useavatar->IMG_BASE64;
  }

}




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
<div class="content" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
		<div class="col-md-8">
			 <div class="panel panel-info">
				<div class="panel-heading">
					<div class="widget-user-image">
					  <img class="img-circle" src="<?php echo $gambaravatar ?>" alt="User Avatar" height="40px" width="40px">
							<?= $nama ?>
					</div>
				</div>
				<div class="pre-scrollableChatBase" id="chat-msg" style="height:300px;background-color:rgba(255, 255, 155, 0.3)">
					<div style="margin-top: -20px;margin-left: 20px" >
						<!-- <div id="chat-chat"> -->
							<?php
								//echo $gv_Chat;
								//echo $body1;

							$body2 = '<div id="chat-chat">';
							// echo $body2;
								// Pjax::begin(['id'=>'msg-chat']);
								// echo Html::mediaList([
								// 	   [
								// 		//  'id'=>'chat-msg',
								// 		'heading' => false,
								// 		'body' => false,
								// 		'imgOptions'=>false,
								// 		'src' => false,
								// 		'img' =>false,
								// 		'items' =>$body2,
								// 	   ],
								// ]);
								// Pjax::end();
							?>
						<!--</div>!-->
					</div>
				</div>
				 <div class="box-footer" style="background-color:rgba(255, 255, 155, 0.3)">
					  <form id='form_id' action="#" method="post">
						<div class="input-group">
						  <textarea class="form-control" id="comment" rows="3" name="message" placeholder="Type Message ..."></textarea>
						  <span class="input-group-btn" >
								<button id="btn" type="button" style="margin-left:10px" class="btn btn-primary">Send</button>
						 </span>
						</div>
					  </form>
					</div><!-- /.box-footer-->

			</div>
		</div>
		<div class="col-md-4">
			 <div class="panel panel-info">
				<div class="panel-heading">
					GROUP CHAT
				</div>
				<div class="pre-scrollableRooms	 panel-body" id="chat-Grp">
					<div  class="row">
						<div style="margin-top: -47px;">
							<?php
								echo $gv_ChatGroup;
							?>
						</div>
					</div>
				</div>
			</div>
			 <div class="panel panel-info">
				<div class="panel-heading">
					ONLINE USERS
				</div>
				<div class="pre-scrollableUser panel-body" id="chat-usr" >
					<div  class="row">
						<div style="margin-top: -47px;">
							<?php
								echo $gv_ChatUser;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php

// $opts = json_encode([
//     'messageUrl' => Url::to(['/widget/chat/message']),
//     // 'chatUrl' => Url::to(['chat']),
//     'templateYou' => $this->blocks['template_you'],
//     'templateMe' => $this->blocks['template_me'],
//     ]);

// $this->registerJs("var chatOpts = $opts;");
// $this->registerJs($this->render('chat.js'));
// $url = \yii\helpers\Url::to(['/widget/chat/message']);
// $js = <<<JS
//      var evtSource = new EventSource("$url");
//     evtSource.onmessage = function(e) {
//         $('<li>').css({color:'red'}).text(e.data).appendTo('#response');
//     }
//     evtSource.addEventListener("ping", function(e) {
//         var obj = JSON.parse(e.data);
//         $('<li>').text("ping at " + obj.time).appendTo('#response')
//     });
// JS;
// $this->registerJs($js);

?>

	<?php

// $url = Url::to(['/widget/chat/message'],true);


//  $js = <<<JS

// // if(typeof(EventSource) !== 'undefined') {
// //    		alert('support');
// // } else {
// //    alert('no support');
// // }
// var sse;
// var container = $('#message-container');

// sse = new EventSource('$url');
//  console.log(sse);

//  // sse.onmessage = function(e) {
//  // 	 var data = JSON.parse(e.data);
//  //       console.log(data);
//  //    }

// sse.addEventListener('chat', function (e) {
//     var data = JSON.parse(e.data);
//      console.log(data);
//     var msgs = data.msgs;
//     $.each(msgs, function () {
//         var msg = this;
//         var row;
//         // if (msg.self == 1) {
//         //     $row = $(chatOpts.templateMe);
//         // } else {
//         //     $row = $(chatOpts.templateYou);
//         //     $row.find('[data-attr='name']').text(msg.name);
//         // }
//         // row.find('[data-attr=time]').text(msg.time);
//        $('row').find("[data-attr=text]").text(msg.text);
//         container.append(row);
//     });
//     if (msgs.length) {
//         container.scrollTop(container.prop('scrollHeight'));
//     }
// });
// JS;
// $this->registerJs($js);

?>


<?php
$params = Yii::$app->request->queryParams;
$id = $params['ChatSearch']['GROUP'];

$chat_groupuser = Yii::$app->getRequest()->getQueryParam('chat');


	$this->registerJs("
	var id =\"".$id."\";
  var chat =\"".$chat_groupuser."\";
	$('#btn').click(function(){
		var comment = $('#comment').val();
		var data = { id : id, comment : comment, chat:chat }
		$.ajax({
				url: '/widget/chat/send-chat',
				type: 'POST',
				//contentType: 'application/json; charset=utf-8',
				data: data,
				dataType: 'json',
				success: function(result) {
					if (result == 1){
						// Success
						 $('#chat').load(window.location + ' #chat');
						 $('#form_id').trigger('reset');

						//$.('#btn').load(location.href + '#chat-msg');
						//$.pjax.reload('#msg-chat-id');
						//$.pjax.reload('#msg-chat-id');
						//$.pjax.reload({container:'#comment-chat-id,#msg-chat-comment'});
						// $.pjax.reload({container:'#msg-chat'});
						//$.pjax.reload({container:'#comment'});

						 $.pjax.reload({container: '#msg-chat', async:false});

						var element = document.getElementById('chat-msg');
						element.scrollTop = element.scrollHeight;
					} else {
						// Fail
					}
				}
			});
	})


 ",$this::POS_READY);




 // $this->registerJs("
 //  /*
 // 	* 	Scroll Position Down
 // 	*	@author ptr.nov@gmail.com
 //  */
	// jQuery(document).ready(function($){
	// 	$(function() {
	// 		startRefresh();
	// 	});

	// 	function startRefresh() {
	// 		setTimeout(function(){
	// 			var element = document.getElementById('chat-msg');
	// 			element.scrollTop = element.scrollHeight;
	// 		}, 1000);
	// 		setTimeout(function(){
	// 	   $('#gv-chat-user').load(window.location + ' #gv-chat-user');
	// 	}, 1000);
	// 		// setTimeout(function(){
	// 		// 	var element = document.getElementById('gv-chat-user');
	// 		// 	element.scrollTop = element.scrollHeight;
	// 		// }, 100);
	// 	 }
	// });
 // ",$this::POS_READY);















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
