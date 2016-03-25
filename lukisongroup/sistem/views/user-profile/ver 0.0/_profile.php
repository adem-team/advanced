<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;


	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[1=RO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1)->mdlpermission;
		}else{		
			return false;
		}	 
	}
	function getPermissionEmployee(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1)->emp;
		}else{		
			return false;
		}	 
	}
	
	/**
     * Create Signature Signature
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPasswordSignature(){		
		$title1 = Yii::t('app', 'Signature');
		$options1 = [ 'id'=>'signature-password',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature-password",											
					  'class' => 'btn btn-default',
		]; 
		$icon1 = '<span class="fa fa-plus fa-lg"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile/signature']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}
	
	/**
     * New|Change|Reset| Password Signature
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	function tombolPasswordSignature(){		
		$title1 = Yii::t('app', 'Signature Password');
		$options1 = [ 'id'=>'add-item',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#profile-signature-password",											
					  'class' => 'btn btn-default',
		]; 
		$icon1 = '<span class="fa fa-plus fa-lg"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/sistem/user-profile']);//,'kd'=>$kd]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}
?>
<body>   
   <div class="container " >
        <div class="row text-center">
            <div class="col-md-12">
             <h1>  USER PROFILE</h1> 
                <br />
           </div>
        </div>
       <div class="row ">
           <div class="col-md-3">
               <img src="http://lukisongroup.com/upload/hrd/Employee/1436076377.jpg"  class="img-responsive img-thumbnail" />
              
           </div>
           <div class="col-md-8">
               <div class="alert alert-info">
                   Your profile is only 45% complete, to enjoy full feaures you have to complete it 100%. 
                   <br /><br />
                   <div class="progress" style="height:5px">
  <div class="progress-bar progress-bar-striped active progress-bar-danger"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">
    <span class="sr-only">45% Complete</span>
  </div>
</div>
                   To complete your profile please <a href="#">click here</a> .
               </div>
             <div class="btn-group pull-right">
  <button type="button" class="btn btn-success">My Settings</button>
  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><a href="#">Setting</a></li>
    <li><a href="#">Change Password</a></li>
    <li><?php echo tombolPasswordSignature(); ?></li>
    <li class="divider"></li>
    <li><a href="#">Logout</a></li>
  </ul>
</div>
               <br /><br />
               <hr />
               <div >
                <h3><strong> Name:</strong> Alexa Chui Renamai</h3>  
                  
                 <h3> <strong> Registered On:</strong> 24th August 2014</h3>  
                <h3>  <strong>  Role: </strong>User</h3>  

                <h3>  <strong> Social Links :</strong></h3>  
                   <br />
                   <a href="#" class="btn btn-primary" >Facebook <i class="glyphicon glyphicon-play"></i></a>
                   <a href="#" class="btn btn-danger" >Google <i class="glyphicon glyphicon-play"></i></a>
                   <a href="#" class="btn btn-info" >Twitter <i class="glyphicon glyphicon-play"></i></a>
               </div>
               
           </div>
       </div>
       <div class="row " >
           <div class="col-md-6">
             <h3>Small Biography :</h3>  
               <hr />
               <p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                   Mauris ac nisl tempus, sollicitudin elit vel, pellentesque lorem. 
                   Maecenas hendrerit laoreet lectus a feugiat. Nunc sodales id ipsum ut maximus. 
                   Morbi pellentesque quis diam nec ullamcorper. Nulla facilisi. Donec non nunc augue. 
                   Integer tincidunt consequat porta.
               </p>

           </div>
           <div class="col-md-6" style="padding-bottom:80px;">
              <h3>Registered Address  :</h3> 
               <hr />
               <h5>568/90 - New Lane Street </h5>  
                  
                 <h5>Free Way Society</h5>  
                <h5>  United States - 2098-89-00</h5>  
           </div>
       </div>
       
   </div>

</body>
</html>
