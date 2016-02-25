<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Lukisongroup Postman</title>
	</head>
	<body style="margin:0px;
				padding:0px;
				border: 0 none;
				font-size: 11px;
				font-family: Verdana, sans-serif;
				background-color: #efefef;">
		<table style="margin-button: 50px; width: 350px; margin: 50px auto 50px auto; border: 1px #fff solid; background: #fff; font-size: 12px; font-family: Verdana, sans-serif;" align="center">
			<tbody>
				<tr>
					<td style="color: #fff; background:blue;text-align:center">
						<h2>LUKISONGROUP POSTMAN</h2>
					</td>
				</tr>
				<tr>				
					<td style="background: #ddd; margin-top:5px; margin-button: 18px; text-align: center;">
						Purchase Order Notification
					</td>
				</tr>		
				<tr>
					<td>
						<table style="font-size: 12px; font-family: Verdana, sans-serif;">							
							<tr>
								<td style="width: 80px; color:black; background:white;text-align:left">
									PO.No
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?php echo $poHeader->KD_PO; ?>
								</td>
							</tr>							
							<tr>
								<td style="color:black; background:white;text-align:left">
									ETA
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?php echo $poHeader->ETD!=''?$poHeader->ETD:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									ETD
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?php echo $poHeader->ETA!=''?$poHeader->ETA:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									Created By
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?php echo $poHeader->SIG1_NM!=''?$poHeader->SIG1_NM:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									Checked By
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?php echo $poHeader->SIG2_NM!=''?$poHeader->SIG2_NM:'none'; ?>
								</td>
							</tr>
							<tr>
								<td style="color:black; background:white;text-align:left">
									Approved By
								</td>
								<td style="color:black; background:white;text-align:left">
									:
								</td>
								<td style="color:black; background:white;text-align:left">
									<?php echo $poHeader->SIG3_NM!=''?$poHeader->SIG3_NM:'none'; ?>
								</td>
							</tr>								
						</table>	
					</td>
				</tr>

				<tr>
					<td style="padding: 9px; color:black; background:white;text-align:left">
						please find the attachment for details or login <a href="http://lukisongroup.com">Lukisongroup.com</a> 
					</td>
				</tr>	
				<tr>
					<td style="padding: 9px; color:red; background:white;text-align:center">
						This email message has been automatically generated, Please do not reply to this message.
					</td>
				</tr>					
				<tr>				
					<td colspan="2" style="background: #ddd; padding: 9px; margin-top:5px; margin-button: 18px; text-align: center;">
						&copy;Lukisongroup 2016
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>