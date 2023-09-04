<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Promena podataka korisnika - Administracija CMS SDStudio</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="../css/admin.css" rel="stylesheet" type="text/css">
</head>
<body>
	{if $smarty.get.modify neq "success"}
		
	{if $smarty.get.modify eq "failed"}
		<b> {$PLG_CHANGEPASS_FAILED}</b>
	{/if}
<div id="content">	
   <h1>{$PLG_PASSWORD}</h1>
	<form action="changepass_final.php" method="POST" name="frmChangePass">
	<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="tablemodifyall">
		<tr>
		<td>
		<table width="200"  border="0"  cellpadding="5" cellspacing="0" class="tablemodify">
		<tr>
			<td colspan="2">
				<p>{$PLG_CHANGEPASSADD_NEW}</p>
			</td>
		</tr>
		<tr>
			<td>
				<input type="text" value="" name="password_new" id="password_new" />
			</td>
			<td>
				<input type="submit" value="{$PLG_SAVE}" id="save_pass" name="save_pass"/>
				<input type="hidden" value="{$adminuserid}" id="adminuserid" name="adminuserid"/>
			</td>
		</tr>
		</table>
		</td>
		</tr>
	</table>
	</form>
	{else}
		
		{if $smarty.get.modify eq "success"}
			<b> {$PLG_CHANGEPASS_SUCCESS} </b>
		{/if}
		
	{/if}
</body>
</html>