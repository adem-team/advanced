<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use lukisongroup\master\models\barangalias;
use lukisongroup\master\models\Distributor;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\label\LabelInPlace;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Customers;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */
/* @var $form yii\widgets\ActiveForm */


$datadis = Distributor::find()->where('STATUS<>3')
                              ->all();
$todis = 'KD_DISTRIBUTOR';
$fromdis = 'NM_DISTRIBUTOR';
$config = ['template'=>"{input}\n{error}\n{hint}"]
?>

<div class="barangalias-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true,
      'enableAjaxValidation'=>true,
      'validationUrl'=>Url::toRoute('/master/customers/valid-alias')
    ]); ?>

    <?= $form->field($model, 'KD_CUSTOMERS')->textInput(['value'=>$id->CUST_KD,'readonly'=>true])->label('Kode Customers') ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['value'=>$nama,'disabled'=>true]) ?>

    <?= $form->field($model, 'KD_ALIAS',$config)->widget(LabelInPlace::classname()); ?>

    <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
      'data' => $model->data($datadis,$todis,$fromdis),
      'options' => ['placeholder' => 'Pilih KD DISTRIBUTOR ...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $datatype =  ArrayHelper::map(Customers::find()->where('STATUS<>3')->groupBy('CUST_NM')->all(), 'CUST_KD', 'CUST_NM');



    $gridColumns = [
              [
          'class'=>'kartik\grid\SerialColumn',
          'contentOptions'=>['class'=>'kartik-sheet-style'],
          'width'=>'10px',
          'header'=>'No.',
          'headerOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'10px',
              'font-family'=>'verdana, arial, sans-serif',
              'font-size'=>'9pt',
              'background-color'=>'rgba(97, 211, 96, 0.3)',
            ]
          ],
          'contentOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'10px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
            ]
          ],
        ],

        [
          'attribute' => 'disnm',
          'label'=>'Nama Distributor',
          'hAlign'=>'left',
          'vAlign'=>'middle',
          'headerOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'150px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
              'background-color'=>'rgba(97, 211, 96, 0.3)',
            ]
          ],
          'contentOptions'=>[
            'style'=>[
              'text-align'=>'left',
              'width'=>'150px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
            ]
          ],
        ],

        [
          'attribute' => 'custnm',
          'label'=>'Nama Customers',
          'hAlign'=>'left',
          'vAlign'=>'middle',
          'headerOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'150px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
              'background-color'=>'rgba(97, 211, 96, 0.3)',
            ]
          ],
          'contentOptions'=>[
            'style'=>[
              'text-align'=>'left',
              'width'=>'150px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
            ]
          ],
        ],
        [
          'attribute' => 'KD_CUSTOMERS',
          'label'=>'Kode Customers',
          'hAlign'=>'left',
          'vAlign'=>'middle',
          'headerOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'200px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
              'background-color'=>'rgba(97, 211, 96, 0.3)',
            ]
          ],
          'contentOptions'=>[
            'style'=>[
              'text-align'=>'left',
              'width'=>'200px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
            ]
          ],
        ],
        [
          'attribute' => 'KD_ALIAS',
          'label'=>' Alias Code',
          'hAlign'=>'left',
          'vAlign'=>'middle',
          'headerOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'200px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
              'background-color'=>'rgba(97, 211, 96, 0.3)',
            ]
          ],
          'contentOptions'=>[
            'style'=>[
              'text-align'=>'left',
              'width'=>'200px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
            ]
          ],
        ],

        [
          'class'=>'kartik\grid\ActionColumn',
          'dropdown' => true,
          'template' => '{view}{update}{price}',
          'dropdownOptions'=>['class'=>'pull-right dropup'],
          'buttons' => [
              'view' =>function($url, $model, $key){
                  return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                                ['view-alias','id'=>$model->ID],[
                                'data-toggle'=>"modal",
                                'data-target'=>"#modal-view",
                                'data-title'=> $model->KD_CUSTOMERS,
                                ]). '</li>';
              },
              'update' =>function($url, $model, $key){
                  return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
                                ['update-alias','id'=>$model->KD_CUSTOMERS],[
                                'data-toggle'=>"modal",
                                'data-target'=>"#modal-create",
                                'data-title'=> $model->KD_CUSTOMERS,
                                ]). '</li>';
              },


                  ],
          'headerOptions'=>[
            'style'=>[
              'text-align'=>'center',
              'width'=>'150px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
              'background-color'=>'rgba(97, 211, 96, 0.3)',
            ]
          ],
          'contentOptions'=>[
            'style'=>[
              'text-align'=>'left',
              'width'=>'150px',
              'height'=>'10px',
              'font-family'=>'tahoma, arial, sans-serif',
              'font-size'=>'9pt',
            ]
          ],

              ],

          ];

    ?>
    <div class="container-full">
    	<div style="padding-left:15px; padding-right:15px">
    		<?= $grid = GridView::widget([
    				'id'=>'gv-brg1-alias',
    				'dataProvider'=> $dataProvider,
    				'filterModel' => $searchModel,
    				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
    				'columns' => $gridColumns,
    				'pjax'=>true,
    					'pjaxSettings'=>[
                // 'neverTimeout'=>true,
    						'options'=>[
    							'enablePushState'=>false,
    							'id'=>'gv-brg1-alias',
    						],
    					 ],
    				'toolbar' => [
    					'{export}',
    				],
    				'panel' => [
    					'heading'=>'<h3 class="panel-title">List Nama Alias</h3>',
    					'type'=>'warning',
    					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Logout',
    							['modelClass' => 'Kategori',]),'/master/customers/price-logout',[
                    'class' => 'btn btn-success'
                  ]),
    					      'showFooter'=>false,
    				],

    				'export' =>['target' => GridView::TARGET_BLANK],
    				'exportConfig' => [
    					GridView::PDF => [ 'filename' => 'Alias'.'-'.date('ymdHis') ],
    					GridView::EXCEL => [ 'filename' => 'Alias'.'-'.date('ymdHis') ],
    				],
    			]);
    		?>
    	</div>
    </div>

</div>
<?php

$this->registerJs("

   $('form#{$model->formName()}').on('beforeSubmit',function(e)
    {
        var \$form = $(this);
        $.post(
            \$form.attr('action'),
            \$form.serialize()

        )
            .done(function(result){

			        if(result == 1 )
                {

                  $(document).find('#cust-code').modal('hide');
                  // $.pjax.reload({container:'#gv-brg1-alias'});
                  // $.pjax({url: '/master/customres/index-alias', container: '#gv-brg-alias'});
                  $('form#{$model->formName()}').trigger('reset');
                  }
                else{
                      console.log(result)
                    }

            });

return false;


});


 ",$this::POS_END);
