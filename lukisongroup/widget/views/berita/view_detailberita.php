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
use dosamigos\gallery\Gallery;

/* namespace models */
use lukisongroup\hrd\models\Employe;
use lukisongroup\widget\models\Commentberita;
use lukisongroup\widget\models\BeritaImage;


/* HEADER foto profile */
$user = $model->CREATED_BY;

/* HEADER cari employe*/
$queryCariEmploye = employe::find()->where(['EMP_ID'=>$user])->andwhere('STATUS<>3')->one();
$ttdbase64 = $queryCariEmploye->SIGSVGBASE64;
$emp_nm = $queryCariEmploye->EMP_NM.' '.$queryCariEmploye->EMP_NM_BLK;
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
	$items = [];
		$attach_file = BeritaImage::find()->where(['ID_USER'=>$user,'TYPE'=>1])->andwhere(['KD_BERITA'=>$model->KD_BERITA])->andwhere(['CREATED_BY'=>$user])->All();

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
  $items1[] = ['src'=>'/upload/barang/df.jpg',
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
            'showControls'=>true,

    ]);
?>

 <?php


    /* array commentar */
    $query = Commentberita::find()->with('profile')->where(['KD_BERITA'=>$model->KD_BERITA])->orderBy(['CREATED_AT'=>SORT_DESC])->all();
    //$body = [];
    $body1 = [];
	$x=0;
    foreach ($query as $key => $value) {
      $emp_ID = $value->profile->EMP_ID;
      $condition = ['and',
      ['ID_USER'=>$emp_ID],
      ['KD_BERITA'=> $model->KD_BERITA],
      ['TYPE'=> 0],
      ['CREATED_AT'=> $value->CREATED_AT],
    ];
      $attach_image = BeritaImage::find()->where($condition)->All();


      if($value->EMP_IMG == "default.jpg")
      {
        $profile = '/upload/hrd/Employee/default.jpg';
      }else{
        $profile = 'data:image/jpg;base64,'.$value->EMP_IMG;
      }
      # code...
		if ($x==0){
			$a=$this->render('_message_left', [
				'profile'=>$profile,
        'attach_image'=>$attach_image,
        'kd_berita'=>$model->KD_BERITA,
				'nama'=>$value->profile->EMP_NM,
				'messageReply'=>$value->CHAT,
				'jamwaktu'=> date('Y-m-d h:i A', strtotime($value->CREATED_AT)),
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
      if($value->EMP_IMG == "default.jpg")
      {
        $profile = '/upload/hrd/Employee/default.jpg';
      }else{
        $profile = 'data:image/jpg;base64,'.$value->EMP_IMG;
      }
			$a=$this->render('_message_right', [
				'profile'=>$profile,
        'kd_berita'=>$model->KD_BERITA,
        'attach_image'=>$attach_image,
				'messageReply'=>$value->CHAT,
				'jamwaktu'=>date('Y-m-d h:i A', strtotime($value->CREATED_AT)),
				'nama'=>$value->profile->EMP_NM,
        'ttd'=>$value->profile->SIGSVGBASE64,
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
    'id'=>$id,
    'ttd'=>$ttdbase64,
    'emp_nm'=>$emp_nm,
    'jam'=>date('h:i A', strtotime($model->CREATED_ATCREATED_BY))
	]);
	$viewBt=Html::mediaList([
		   [
			'body' => $bodyHead,
			'imgOptions'=>['width'=>"84px",'height'=>"84px",'class'=>'img-circle'], //setting image display,
			'img' =>$foto_profile,
			'items' =>$body1,
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
 /* componen user */
        $profile_user = Yii::$app->getUserOpt->profile_user()->emp;
        $emp_img = $profile_user->EMP_IMG;
        $emp_img_base64 = $profile_user->IMG_BASE64;

        /* foto profile */
        if($emp_img_base64 == '')
        {
         $emp_img_base64 = "default.jpg";
         $foto = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/default.jpg', ['width'=>'100','height'=>'80', 'align'=>'center' ,'class'=>'img-circle']);
        }else{
          $emp_img_base64 = $profile_user->IMG_BASE64;
         $foto= Html::img('data:image/jpg;base64,'.$emp_img_base64, ['width'=>'100','height'=>'80', 'align'=>'center' ,'class'=>'img-circle']);
        }

?>


<?php
/**@author wawan
  *js close news
  *event click(POS_READY)
  *url = /widget/berita/close-berita
*/
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


  /**@author wawan
    *js modal render commentar
  */
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
  'header' => '<h4 class="modal-title"><b>'.$foto.' Comment </b></h4>',
  'headerOptions'=>[
    'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
  ]
]);
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
