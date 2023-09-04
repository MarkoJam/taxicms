<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>Promena proizvođača - Administracija CMS SDStudio</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link href="../../css/admin.css" rel="stylesheet" type="text/css">
		<link href="../../css/bootstrap.css" rel="stylesheet">
<link href="../../css/bootstrap-theme.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../javascript/bootstrap.min.js"></script>
	</head>
		
	<body>
		{include file="../../templates/productsmenu.tpl"}
			<div id="content">
				<h1>{$PLG_PRODUCT_COMMENT_MODIFY_MAINTITLE}</h1>
			
				<form name="editcategory" action="modify_final.php" method="post" enctype="multipart/form-data">
				<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="tablemodifyall">
					<tr>
		    			<td>
							<table width="600"  border="0"  cellpadding="5" cellspacing="0" class="tablemodify">
								<tr>
		    						<td width="150">{$PLG_PRODUCT_COMMENT_HEADER_PRODUCT}: </td>
		    						<td width="450"><strong>{$proizvodnaziv}</strong></td>
		  						</tr>
		  						<tr>
		    						<td width="150">{$PLG_PRODUCT_COMMENT_HEADER_USER}: </td>
		    						<td width="450">{$imeprezime}</td>
		  						</tr>
		  						<tr>
		    						<td width="150">{$PLG_PRODUCT_COMMENT_HEADER_TITLE}:</td>
		    						<td width="450"><input name="naslov" type="text" value="{$naslov}" size="40" class="form-control"></td>
		  						</tr>
		  						<tr>
		    						<td width="150">{$PLG_PRODUCT_COMMENT_HEADER_COMMENT}:</td>
		    						<td width="450"><textarea name="komentar" rows="5" class="form-control">{$komentar}</textarea></td>
		  						</tr>
		  						

							</table>
							
							<input name="proizvodkomentarid" type="hidden" id="proizvodkomentarid" value="{$proizvodkomentarid}">
							<input name="imeprezime" type="hidden" id="imeprezime" value="{$imeprezime}">
							<input name="datumkreiranja" type="hidden" id="datumkreiranja" value="{$datumkreiranja}">
							<input name="proizvodid" type="hidden" id="proizvodid" value="{$proizvodid}">
							<input name="userid" type="hidden" id="userid" value="{$userid}">
		    				<input name="modifyfinbutt" type="submit" id="modifyfinbutt" value="{$PLG_PRODUCT_COMMENT_BUTTON_SAVE}" class="btn btn-default">
						</td>
		  			</tr>
				</table>
			</form>
		</div>
		<div id="footer"><p>Powered by <font color="#2678A8"><strong>CMS</strong></font> <font color="#498726"><strong>STUDIO</strong></font></p></div>
	</body>
</html>