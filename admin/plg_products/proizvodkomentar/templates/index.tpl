<html>
	<head>
		<title>Administracija - SD Studio CMS</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link href="../../css/admin.css" rel="stylesheet" type="text/css">
		<link href="../../css/bootstrap.css" rel="stylesheet">
		<link href="../../css/bootstrap-theme.css" rel="stylesheet">
	</head>
	<script src="../../javascript/functions.js" language="JavaScript"  type="text/JavaScript"></script>
	
	<body>
	{include file="../../templates/productsmenu.tpl"}
	<div id="content">
	<h1>{$PLG_PRODUCTCOMMENT_MAINTITLE}</h1>

	{if $smarty.request.statusmessage eq "modify_success"}
		<div class="green_message">{$PLG_PRODUCT_COMMENT_CHANGE_SUCCESS}</div>
	{/if}
	{if $smarty.request.statusmessage eq "delete_success"}
		<div class="blue_message">{$PLG_PRODUCT_COMMENT_DELETE_SUCCESS}</div>
	{/if}
	{if $smarty.request.statusmessage eq "failed"}
		<div class="red_message">{$PLG_PRODUCT_COMMENT_CHANGE_FAILED}</div>
	{/if}
	
	<form action="index.php" method="POST" id="formTable" name="formTable">
	
	{	html_table_advanced
	  		cnt_all_rows=$tbl_all_rows_count
			browseString=$tbl_browseString
			scriptName=$scriptName
			cnt_rows=$tbl_row_count
			rowOffset=$tbl_offset
			
			tr_attr=$tbl_tr_attributes
			td_attr=$tbl_td_attributes
			loop=$tbl_content
			cols=$tbl_cols_count
			tableheader=$tbl_header
			table_attr='cellspacing=0 class="index"'
			message=$poruka
	}
	</form>
<div id="links">
  {*<a href="insert_pre.php"><img src="../../images/add_new.gif" border="0">&nbsp;{$PLG_PRODUCT_COMMENT_ADD_NEW}</a>*}
</div>
</div>
<div id="footer"><p>Powered by <font color="#2678A8"><strong>CMS</strong></font> <font color="#498726"><strong>STUDIO</strong></font></p></div>
</body>
</html>