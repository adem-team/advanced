<?php
	/*
	 * Declaration Componen User Permission
	 * Function profile_user_crm
	*/

	function getPermissionUser(){
		if (Yii::$app->getUserOptcrm->profile_user()){
			return Yii::$app->getUserOptcrm->profile_user();
		}else{
			return false;
		}
	}
	function getPermissionEmp(){
		if (Yii::$app->getUserOptcrm->profile_user()->userprofile){
			return Yii::$app->getUserOptcrm->profile_user()->userprofile;
		}else{
			return false;
		}
	}

	  
?>

<html>
<div style="font-family: tahoma ;font-size: 9pt;">
	You've changed your login password in <a href="http://www.lukisongroup.com">www.lukisongroup.com</a>
</div>
<div style="font-family: tahoma ;font-size: 9pt;">
	<dl>
		<dt style="width:80px;float:left">Account</dt>
		<dd>: <?=getPermissionUser()->username;?></dd>
		<dt style="width:80px;float:left">Name</dt>
		<dd>: <?=getPermissionEmp()->NM_MIDDLE .' '.getPermissionEmp()->NM_END;?> </dd>
		<dt style="width:80px;float:left">Email</dt>
		<dd>: <?=getPermissionUser()->email;?></dd>
		<dt style="width:80px;float:left">Status</dt>
		<dd>: Testing ver.1.1 </dd>
		<dt style="width:80px;float:left">Generate</dt>
		<dd>: Your password has been changed to : <?=$newPassword;?></dd>
	</dl>
<div>
</html>
