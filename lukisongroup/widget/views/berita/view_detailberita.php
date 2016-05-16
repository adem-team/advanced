<?php
/* extensions */
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

/* namespace models */
use lukisongroup\hrd\models\Employe;
use lukisongroup\widget\models\Commentberita;
use lukisongroup\widget\models\BeritaImage;
use dosamigos\gallery\Gallery;

/* HEADER foto profile */
$user = $model->CREATED_BY;




/* HEADER cari employe*/
$queryCariEmploye = employe::find()->where(['EMP_ID'=>$user])->andwhere('STATUS<>3')->one();

$emp_img = $queryCariEmploye->IMG_BASE64;
if(count($queryCariEmploye) == 0 || $emp_img =='')
{
  $foto_profile = '/upload/hrd/Employee/default.jpg';
}else{
  $foto_profile = 'data:image/jpg;base64,'.$emp_img;
}

	//$queryAttachHeader = BeritaImage::find()->where(['ID_USER'=>$user])->andwhere(['CREATED_BY'=>$user])->All();
	// $aryProviderAttachHeader= new ArrayDataProvider([
		//'key' => 'ID',
		// 'allModels'=>queryAttachHeader,
		  // 'pagination' => [
			// 'pageSize' =>50,
		// ]
	// ]);
	//$aryPrvData=$aryProviderAttachHeader->getModels[0];
	//print_r($aryPrvData);

	$items = [];
		// $attach_file = BeritaImage::find()->where(['ID_USER'=>$user])->andwhere(['CREATED_BY'=>$user])->All();

		// $aryFieldHeader[]=ArrayHelper::getColumn($attach_file,'ATTACH64');
		// $no=0;
		// foreach ($attach_file as $key => $value) {
		// 	$aryFieldHeaderX[]=[
		// 		'attribute'=>$key,
		// 		'format'=>'raw',
		// 		'label'=>'',
		// 		'value'=>function($model){
		// 			$base64 ='data:image/jpg;charset=utf-8;base64,'.$model[0]; //?????
		// 			return Html::img($base64,['width'=>'100','height'=>'60','class'=>'img-circle']);
		// 		 },
		// 		//'format'=>['image',['width'=>'100','height'=>'120']],
		// 		/* 'value'=>function($model){
		// 			$base64 ='data:image/jpg;charset=utf-8;base64,'.$model['ATTACH64'];
		// 			//return Html::img($base64,['width'=>'100','height'=>'60','class'=>'img-circle']);
		// 			return $model['ATTACH64']!=''?Html::img($base64,['width'=>'140','height'=>'140']):Html::img(Yii::$app->urlManager->baseUrl.'/df.jpg',['width'=>'140','height'=>'140']);
		// 		}, */
    //
		// 		'contentOptions'=>[
		// 			'style'=>[
		// 				'text-align'=>'center',
		// 				'width'=>'10px',
		// 				'height'=>'10px',
		// 				'font-family'=>'tahoma, arial, sans-serif',
		// 				'font-size'=>'9pt',
		// 				'background-color'=>'black',
		// 				'border'=>'0px',
		// 			]
		// 		],
		// 	];
		// 	$no=$no+1;
		// }









if(count($attach_file)== 0)
{
  for($a = 0; $a < 2; $a++)
  {
  $items[] = ['src'=>'/upload/barang/df.jpg',
  'imageOptions'=>['width'=>"150px"]
  ];
  }
}else{
  foreach ($attach_file as $key => $value) {
   # code...
   $items1[] = [
         'src'=>'data:image/pdf;base64,'.$value['ATTACH64'],
         'imageOptions'=>['width'=>"120px",'height'=>"120px",'class'=>'img-rounded'], //setting image display
         // 'Options'=>['id'=>$value['ID']],
         // 'showControls'=>false
     ];

  }
}

      # code...


     $itemHeaderAttach= Gallery::widget([
            'id'=>'headergalery',
            'items' =>$items1,
             // 'options' => [
             //   'id' =>$model->ID
             // ],
            'showControls'=>true,

    ]);








		// $itemDetailAttach= Gallery::widget([
		// 				'id'=>'header-detail1',
		// 				'items' => $items2,
    //
		// ]);

?>

 <?php

 /*
  * @author : wawan
    * @since 1.0
 */

 /* function Add_close($model){
     $title = Yii::t('app','');
     $options = [ 'id'=>'berita-isi-id-close',
               'data-pjax' => true,
               'data-toggle-close'=>$model->KD_BERITA,
               'class'=>'btn btn-danger btn-xs',
     ];
     $icon = '<span class="glyphicon glyphicon-remove-sign">Close</span>';
     $label = $icon . ' ' . $title;
     $content = Html::a($label,'', $options);
     return $content;
 }
 // print_r($model->CREATED_BY);
 // die();

 if($model->CREATED_BY != $id )
 {
    $btnclose = "";

 }else{

   $btnclose = Add_close($model);
 } */



 /*
  * @author : wawan
    * @since 1.0
 */

 /* function berita_reply($model){
     $title = Yii::t('app','');
     $options = [ 'id'=>'berita-reply-id',
             'data-toggle'=>"modal",
             'data-target'=>"#berita-reply-id-join",
             'class'=>'btn btn-info btn-xs',
             'title'=>'Reply'
     ];
     $icon = '<span class="fa fa-plus fa-lg"> Reply Discusion</span>';
     $label = $icon . ' ' . $title;
     $url = Url::toRoute(['/widget/berita/join-comment','KD_BERITA'=>$model->KD_BERITA]);
     $content = Html::a($label,$url, $options);
     return $content;
 }

 if($model->STATUS == 0)
 {
   $btnreply = "";
 }else{
   $btnreply = berita_reply($model);
 } */



    /* array commentar */
    $query = Commentberita::find()->where(['KD_BERITA'=>$model->KD_BERITA])->orderBy(['CREATED_AT'=>SORT_DESC])->asArray()->all();
    //$body = [];
    $body1 = [];
	$x=0;
    foreach ($query as $key => $value) {
      # code...

		$queryEmp = employe::find()->where(['EMP_ID'=>$value['CREATED_BY']])->andwhere('STATUS<>3')->one();
		$foto_detail = $queryEmp->IMG_BASE64;
		if($foto_detail == ''){
			$profile = '/upload/hrd/Employee/default.jpg';
		}else{
			$profile = 'data:image/jpg;charset=utf-8;base64,'.$foto_detail;
		}

		if ($x==0){
			$a=$this->render('_message_left', [
				'profile'=>$profile,
				'nama'=>$nama,
				'messageReply'=>$value['CHAT'],
				'jamwaktu'=> date('Y-m-d h:i A', strtotime($value['CREATED_AT'])),
				'nama'=>$nama,
				'items'=>$items,
				'lampiran'=>Html::panel(
						[
							'id'=>'as',
							//'heading' => '<div>Attach</div>',
							'body'=>$itemDetailAttach,
						],
						Html::TYPE_INFO
					),
			]);
			$x=1;
		}else{
			$a=$this->render('_message_right', [
				'profile'=>$profile,
				'messageReply'=>$value['CHAT'],
				'jamwaktu'=>date('Y-m-d h:i A', strtotime($value['CREATED_AT'])),
				'nama'=>$nama,
				'items'=>$items,
				'lampiran'=>Html::panel(
						[
							//'heading' => '<div>Attach</div>',
							'body'=>'',//$itemHeaderAttach,
						],
						Html::TYPE_INFO
					),
			]);
			$x=0;
		}

		$body .=$a;
    }
	$body1 [] = ['body'=>$body,'img' =>false];


	$dataProviderImageHeader= new ArrayDataProvider([
				//'key' => 'id',
				'allModels'=>$aryFieldHeader,
				'pagination' => [
					'pageSize' => 5,
					]
			]);

	/* HEADER CREATED*/
	$bodyHead=$this->render('_view_detailberita_headline', [
		'model' => $model,
		'itemHeaderAttach'=>$itemHeaderAttach,
		'itemDetailAttach'=>$itemDetailAttach,
		'dataProviderImageHeader'=>$dataProviderImageHeader,
		'aryFieldHeaderX'=>$aryFieldHeaderX,
		// 'items'=>$items,
	]);
	$viewBt=Html::mediaList([
		   [
			//'heading' => "<div class='box-header with-border'>".$model->JUDUL."</div>",
			//'body' => "<div class='box-footer box-comments'>".$model->ISI."</div><div class='box-footer box-comments'><div>".$btnreply." ".$btnclose."</div></div>",
			'body' => $bodyHead,
			'imgOptions'=>['width'=>"84px",'height'=>"84px",'class'=>'img-circle'], //setting image display,
			//'src' => '#',
			// 'srcOptions'=>[
				 // 'style'=>[
					 // 'background-color'=>'rgba(0, 95, 218, 0.3)',
					 // 'width'=>"90px",'height'=>"90px",'padding-top'=>'3px','padding-left'=>'3px',
				 // ]
			// ],
			'img' =>$foto_profile,
			'items' =>$body1, //"<div class='box-footer box-comments'><div class='box-comment'>".$body."</div></div>",
		   ],
	]);

?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
		<div class="col-md-12">
			<?php
				 echo Html::panel(
					[
						'heading' => "BERITA ACARA ",
						'body'=>$viewBt,
					],
					Html::TYPE_INFO
				);
			?>
		</div>
	</div>
</div>

<?php
// $this->registerJs("
// $('#{$model->ID}').on('click', function (event) {
//         var val = $('').val();
//         alert(val);
//         $('#modal').modal('show')
//   }); ",$this::POS_READY);
//  ?>


 <!-- <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
      <! Modal content-->
      <!-- <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body"> -->
          <?php
          //     $kd_berita =  Yii::$app->getRequest()->getQueryParam('KD_BERITA');
          //     $file_upload = BeritaImage::find()->where(['KD_BERITA'=>$kd_berita])->all();
          // foreach ($file_upload as $key => $value) { -->
            # code...
            // $items_attach[] = [
            //       'src'=>'data:image/pdf;base64,'.$value['ATTACH64'],
            //       'imageOptions'=>['width'=>"120px",'height'=>"120px",'class'=>'img-rounded'], //setting image display
            //       // 'Options'=>['class'=>'crousel slide'],
            //       // 'showControls'=>false
            //   ];


          //   //if($value['ATTACH64']!=''){
          //     $aryFieldHeader1[]=
          //         /* 'clm'.$key=>[
          //           'id'=>$value['ID'],
          //           'nilai'=>$value['ATTACH64'],
          //         ] */
          //         //'id'=>$value['ID'],
          //         ['clm'.$key.'=>'.$value['ATTACH64'],];
          //   //}
          //
          //
          //
          // }
          //
          // echo $itemHeaderfile= Gallery::widget([
      		// 				'id'=>'header-galery',
      		// 				'items' =>$items_attach,
          //         // 'options' => [
          //         //   'id' =>$model->ID
          //         // ],
      		// 				// 'showControls'=>false,
          //
      		// ]);

           ?>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>




<?php
$this->registerJs("
  $('#berita-isi-id-close').click(function(e){
    e.preventDefault();
    var idx = $(this).data('toggle-close');
    $.ajax({
        url: '/widget/berita/close-berita',
        type: 'POST',
        data:'id='+idx,
        dataType: 'json',
        success: function(result) {
          if (result == 1){
            // Success
            $('#berita-reply-id').hide(); //TO hide
          } else {
            // Fail
          }
        }
      });

  });
  ",$this::POS_READY);


$this->registerJs("
  $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  $('#berita-reply-id-join').on('show.bs.modal', function (event) {
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
    });
",$this::POS_READY);
Modal::begin([
  'id' => 'berita-reply-id-join',
  'header' => '<h4 class="modal-title"><b> Comment </b></h4>',
  'headerOptions'=>[
    'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
  ]
  // 'size' => Modal::,
]);
  //echo '...';
Modal::end();


// $this->registerJs("
// 	// dosamigos.gallery = (function($){
// 		// var options = {
// 			// container: document.getElementById('blueimp-gallery');
// 		// };
//
// 	// }
// ",$this::POS_READY);
?>
