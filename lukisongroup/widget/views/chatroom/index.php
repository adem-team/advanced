<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\widget\models\GroupchatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chatroom';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groupchat-index">

   <?php

function tombolmember($url,$model){
                                $title = Yii::t('app', 'Member');
                                $options = [ 
                                        'id'=>'member',
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#gv-chat-create",
                                         // 'data-confirm'=>'Anda yakin ingin ?',
                                        ]; 
                    
					$icon ='<span class="fa fa-plus fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/widget/chatroom/createmember','id'=>$model->SORT]);
					// $options['tabindex'] = '-1';
                                return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL; 
                             }
                             
                             
function tomboledit($url,$model){
                                 $title = Yii::t('app', 'Edit');
                                 $options = [ 
                                                'id'=>'edit',
                                                'data-toggle'=>"modal",
                                                'data-target'=>"#gv-chat-create",
                                                // 'data-confirm'=>'Anda yakin ingin ?',
                                            ]; 
                    
					$icon = '<span class="fa fa-pencil-square-o fa-lg"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/widget/chatroom/update','id'=>$model->ID]);
					// $options['tabindex'] = '-1';
                                 return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL; 
                             }
                             
function tombolview($url,$model){
                                 $title = Yii::t('app', 'view');
                                 $options = [ 
                                                'id'=>'view',
                                                'data-toggle'=>"modal",
                                                'data-target'=>"#gv-chat-view",
                                                // 'data-confirm'=>'Anda yakin ingin ?',
                                            ]; 
                    
					$icon = '<span class="glyphicon glyphicon-zoom-in"></span>';
					$label = $icon . ' ' . $title;
					$url = Url::toRoute(['/widget/chatroom/view','id'=>$model->ID]);
					// $options['tabindex'] = '-1';
                                 return '<li>' . Html::a($label, $url, $options) . '</li>' . PHP_EOL; 
                             }                             
       
       
       
       ?>
    
    
<?= $gv_Chat = GridView::widget([
    
        'id'=>'gv-chat',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,		
	    'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                
            [
                'label'=>'GROUP',
		'attribute'=>'SORT',
		'vAlign'=>'middle',
		'value'=>function ($model) { 
                                    $sort = lukisongroup\widget\models\Chatroom::find()->where(['ID'=>$model->SORT])->one();
                                     return $sort->GROUP_NM;                                                        
                                        },
				
                'filterType'=>GridView::FILTER_SELECT2,
		'filter'=>ArrayHelper::map(lukisongroup\widget\models\Chatroom::find()->where('ID = SORT')->asArray()->all(), 'ID', 'GROUP_NM'),
                'filterWidgetOptions'=>[
                                'pluginOptions'=>['allowClear'=>true],
                             ],
            'filterInputOptions'=>['placeholder'=>'GroupChat'],
              'group'=>true,
                                        
            ],
           
            [
		'label'=>'Member',
		'attribute'=>'GROUP_NM',
		'vAlign'=>'middle', 
                
            ],
         
		
            [
		'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
		'template' => '{view} {create}{update}',
                'dropdownOptions'=>['class'=>'pull-right dropup'],		
                    'buttons' => [
					'view' =>function($url,$model){
                                                                         return tombolview($url,$model);
                                                                       },
						
					'create' =>function($url,$model){
                                                                            return tombolmember($url,$model);
                                                                         },
                                        'update' => function ($url,$model) {
                                                                                return tomboledit($url,$model);
                                                                            },
						
				],		
            ],
        ],
		/*
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'Header Before 1', 'options'=>['colspan'=>5, 'class'=>'text-center warning']], 
					['content'=>'Header Before 2', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
					['content'=>'Header Before 3', 'options'=>['colspan'=>3, 'class'=>'text-center warning']], 
				],
				'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
		*/
		//'floatHeaderOptions'=>50,
	'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-chat',                
               ],
        ],
		'toolbar'=> [
			['content'=>
				Html::a('<i class="glyphicon glyphicon-plus"></i>',['create'],[
					  'data-toggle'=>"modal",
					  'data-target'=>"#gv-chat-create",
					   'type'=>'button',
					   'class'=>'btn btn-success',
					  //'data-title'=> $model->PILOT_ID,
					  ] 
					// ['
					// type'=>'button',
					// '', 
					// 'class'=>'btn btn-success', 
				 //]
				 ) .' ' .												
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
					// 'data-pjax'=>0, 
					'class'=>'btn btn-default', 
					''])
			],
			'{export}',
			'{toggleData}',
		],
		'panel'=>['type'=>'info', 'heading'=>'Chat Room'],
		'hover'=>true, //cursor select
		'responsive'=>true,
		//'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export'=>[//export like view grid --ptr.nov-
			'fontAwesome'=>true,
			'showConfirmAlert'=>false,
			//'target'=>GridView::TARGET_BLANK
		],
    ])?>

</div>

<?php

$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#gv-chat-create').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
		",$this::POS_READY);

Modal::begin([
			'id' => 'gv-chat-create',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-user"></div><div><h4 class="modal-title"> CHAT ROOM</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
		]);
Modal::end();

$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#gv-chat-view').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title') 
				var href = button.attr('href') 
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)					
					});
				}),			
		",$this::POS_READY);

Modal::begin([
			'id' => 'gv-chat-view',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-user"></div><div><h4 class="modal-title">Group Chat</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
		]);
Modal::end();



?>
