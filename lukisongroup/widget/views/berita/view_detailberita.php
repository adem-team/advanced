<?php
/* extensions */
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* namespace models */
use lukisongroup\hrd\models\Employe;
use lukisongroup\widget\models\Commentberita;



/* foto profile */
$user = $model->CREATED_BY;

/* cari employe*/
$queryCariEmploye = employe::find()->where(['EMP_ID'=>$user])->andwhere('STATUS<>3')->one();

$emp_img = $queryCariEmploye->EMP_IMG;
if(count($queryCariEmploye) == 0 || $queryCariEmploye =='')
{
  $foto_profile = '/upload/hrd/Employee/default.jpg';
}else{
  $foto_profile = '/upload/hrd/Employee/'.$emp_img;
}
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
		$foto = $value['EMP_IMG'];
		if($foto == ''){
			$profile = '/upload/hrd/Employee/default.jpg';
		}else{
			$profile = '/upload/hrd/Employee/'.$foto.'';
		}

		if ($x==0){
			$a=$this->render('_message_left', [
				'profile'=>$profile,
				'nama'=>$nama,
				'messageReply'=>$value['CHAT'],
        'jamwaktu'=> date('Y-m-d h:i A', strtotime($value['CREATED_AT'])),
        'nama'=>$nama
			]);
			$x=1;
		}else{
			$a=$this->render('_message_right', [
				'profile'=>$profile,
				'nama'=>$nama,
				'messageReply'=>$value['CHAT'],
        'jamwaktu'=>date('Y-m-d h:i A', strtotime($value['CREATED_AT'])),
        'nama'=>$nama
			]);
			$x=0;
		}

		$body .=$a;
    }
	$body1 [] = ['body'=>$body,'img' =>false];

	/* HEADER CREATED*/
	$bodyHead=$this->render('_view_detailberita_headline', [
		'model' => $model,
	]);
	$viewBt=Html::mediaList([
		   [
			'heading' => "<div class='box-header with-border'>".$model->JUDUL."</div>",
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

?>
