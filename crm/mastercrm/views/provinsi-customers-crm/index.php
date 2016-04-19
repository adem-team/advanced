

<?php

use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use crm\mastercrm\models\Province;
use yii\bootstrap\Modal;

?>





<?php
// grid province

echo $tabprovince = \kartik\grid\GridView::widget([
  'id'=>'gv-prov',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
   'columns'=>[
       ['class'=>'kartik\grid\SerialColumn'],

             'PROVINCE',

     [ 'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                          'dropdown' => true,
                            'dropdownOptions'=>['class'=>'pull-right dropup'],
							'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return '<li>'.Html::a('<span class="glyphicon glyphicon-eye-open"></span>'.Yii::t('app', 'View'),
                                                                ['viewpro','id'=> $model->PROVINCE_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#view3",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]).'</li>';
                            },

                             'update' =>function($url, $model, $key){
                                    return '<li>'. Html::a('<span class="glyphicon glyphicon-pencil"></span>'.Yii::t('app', 'Update'),
                                                                ['updatepro','id'=>$model->PROVINCE_ID],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#form3",
                                                                'data-title'=> $model->PROVINCE,
                                                                ]).'</li>';
                                                      },

                                               ],
                                       ],
                              ],


    'panel'=>[

      'type' =>GridView::TYPE_SUCCESS,
			'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Barangumum',]),'/mastercrm/provinsi-customers-crm/createprovnce',[
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
                'id'=>'gv-prov',
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


    ]);

    // create and update via modal province
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
      Modal::begin([
              'id' => 'form3',
              'header' => '<h4 class="modal-title">LukisonGroup</h4>',
                  ]);
      Modal::end();


    /*view via modal province */
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
      ",$this::POS_READY);
    Modal::begin([
            'id' => 'view3',
            'header' => '<h4 class="modal-title">LukisonGroup</h4>',
          ]);
    Modal::end();


?>
