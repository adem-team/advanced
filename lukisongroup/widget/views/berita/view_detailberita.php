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

 function Add_close($model){
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
 }



 /*
  * @author : wawan
    * @since 1.0
 */

 function berita_reply($model){
     $title = Yii::t('app','');
     $options = [ 'id'=>'berita-reply-id',
             'data-toggle'=>"modal",
             'data-target'=>"#berita-reply-id-join",
             'class'=>'btn btn-info btn-xs',
             'title'=>'Reply'
     ];
     $icon = '<span class="fa fa-plus fa-lg">Join Discusion</span>';
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
 }





 ?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div  class="row">
	<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b><?= $model->JUDUL ?></b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>

		</div>
	</div>

  <div class="row">

    <?php
    /* array commentar */
    $query = Commentberita::find()->where(['KD_BERITA'=>$model->KD_BERITA])->asArray()->all();
    $body = [];
    foreach ($query as $key => $value) {
      # code...
      $foto = $value['EMP_IMG'];
      if($foto == '')
      {
        $profile = '/upload/hrd/Employee/default.jpg';
      }else{
        $profile = '/upload/hrd/Employee/'.$foto.'';
      }

      $body [] = [
        // 'heading' => $nama,
       'body' => $value['CHAT'],
      //  'src' => '#',
       'img' => $profile,
         'imgOptions'=>['width'=>"64px",'height'=>"64px",'class'=>'img-rounded'], //setting image display,

     ];
    }
    Pjax::begin(['id'=>'diva']);

    echo Html::panel(
      [
        'heading' => '<div></div>',
        // 'body'=>'<div class="panel-body">'.$foto_profile.''.$model->ISI.'</div>',
        'postBody' => Html::mediaList([
       [
        'heading' => $model->JUDUL,
        'body' => $model->ISI,
        'imgOptions'=>['width'=>"64px",'height'=>"64px",'class'=>'img-rounded'], //setting image display,
        'src' => '#',
        'img' => $foto_profile,
        'items' => $body
       ],

   ]),
   'footer'=> '<div>'.$btnreply.' '.$btnclose.'</div>',
    'headingTitle' => true,
    'footerTitle' => true,
      ],
      Html::TYPE_INFO
    );
    Pjax::end();
    ?>
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
