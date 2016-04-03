<html>
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Your Custom CSS here -->
		<!--https://msdn.microsoft.com/en-us/library/ms537512(v=vs.85).aspx-->
		<!--Outlook 2000, 2002, 2003-->
		<!--[if (gte mso 9)|(IE)]>
		<![endif]-->
		<!--Outlook 2007-->
		<!--[if mso 12]>
			<style type="text/css">

			</style>
		<![endif]-->
		<!--Outlook 2010-->
		<!--[if mso 14]>
			<style type="text/css">
			</style>
		<![endif]-->
		<!--Outlook 2013-->
		<!--[if mso 15]>
			<style type="text/css">
			</style>
		<![endif]-->
		<!--[if !mso]><!-- -->
		<!--<![endif]-->
		<!--CSS to only target Outlook 2007 and above-->
		<!--[if mso]><!-- -->
		<!--<![endif]-->
		<style type="text/css">
		<?php include("../../lukisongroup/web/widget/bootstrap-mail/dist/css/bootstrap.css"); ?>
		</style>
	</head>
	<body>
	  <?php
		echo Yii::$app->controller->renderPartial('_pdf',[
      'data' => $data,
      'datainternal'=>$datainternal,
      'datacus'=>  $datacus,
      'datadis'=>$datadis,
      'datacorp'=>$datacorp,
      'datasum'=>$datasum,
      'dataProvider'=>$dataProvider
		]);
	  ?>
	</body>
</html>
