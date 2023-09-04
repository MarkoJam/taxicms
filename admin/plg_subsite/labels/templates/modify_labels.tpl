<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Anketa promena - Administracija CMS SDStudio</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<script language="JavaScript" type="text/javascript" src="../javascript/html2xhtml.js"></script>
	<script language="JavaScript" type="text/javascript" src="../javascript/richtext.js"></script>
	{literal}
	<script type="text/javascript" language="javascript1.2">
		function GETLinkPromeni(param0, param1)
		{
			this.window.document.location = "modify_poll.php?modifypitanje=1&pollid="+param0+"&pollquestionid="+param1+"&description="+document.glForma.description.value+"&header="+document.glForma.header.value+"&statusid="+document.glForma.statusid.options[document.glForma.statusid.selectedIndex].value;
		}
		function GETLinkObrisi(param0, param1)
		{
			this.window.document.location = "delete_final.php?deletepitanje=1&pollid="+param0+"&pollquestionid="+param1+"&description="+document.glForma.description.value+"&header="+document.glForma.header.value+"&statusid="+document.glForma.statusid.options[document.glForma.statusid.selectedIndex].value;
		}
	</script>
	{/literal}
	
	<link href="../css/admin.css" rel="stylesheet" type="text/css">
	{if $reload eq "true"}
	<script type="text/javascript" language="javascript1.2">
	<!--
		window.parent.frames['frmLeft'].location.replace('../frm_left.php?page_id={$page_id_left}');
	//-->
	</script>
	{/if}
</head>

<body>
	<div id="content">
		<h1></h1>
		<form name="glForma" id="glForma" action="modify_poll_final.php" method="post" enctype="multipart/form-data">
		<table width="100%"  border="0" cellpadding="5" cellspacing="0" class="tablemodifyall">
		<tr>
		    <td>
				<table width="600"  border="0"  cellpadding="5" cellspacing="0" class="tablemodify">
		  		<tr>
					<td width="150">
						Naziv ankete
						<input name="header" type="text" value="{$poll.header}" size="40">
					</td>
				    <td width="150" valign="bottom">Anketno pitanje 1
				    	<input name="description" type="text" value="{$poll.description}" size="40">
				    </td>
				    <td width="150" valign="bottom">Anketno pitanje 2
				    	<input name="description1" type="text" value="{$poll.description1}" size="40">
				    </td>
					<td width="50" valign="bottom">
						{$PLG_STATUS} 
						 <select name="statusid">
	  						{html_options values=$status_val selected=$status_sel output=$status_out}
  						</select>
  					</td>
					</td>
				</tr>
				
				<tr>
					<td colspan="5">
					<h2>{$PLG_ANSWER}</h2>
				    	  <input name="titled" id="titled" value="" size="20" maxlength="255" type="text">
				    	 <select name="grouppoll">
	  						<option value="1">Odgovor za prvo pitanje</option>
	  						<option value="2">Odgovor za drugo pitanje</option>
  						 </select>  
				    	  <input name="addbutt" type="submit" id="addbutt" value="{$PLG_ADD_ANSWER}">
				    <br/>
				
				    {html_table_advanced 
						browseString=$tbl_browseString 
						scriptName=$scriptName 
						cnt_rows=$tbl_row_count 
						rowOffset=$tbl_offset 
						tr_attr=$tbl_tr_attributes 
						td_attr=$tbl_td_attributes 
						loop=$tbl_content 
						cols=$tbl_cols_count 
						tableheader=$tbl_header table_attr='cellspacing=0 class="index"' 
						message=$poruka 
						cnt_all_rows=$tbl_all_rows_count
				    }
				 
					<td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>	
				</tr>
				<tr>
					<td colspan="4"><input name="modifyfinbutt" type="submit" id="modifyfinbutt" value="{$PLG_SAVE}"></td>
				</tr>
			</table>
			<input name="pollid" type="hidden" id="pollid" value="{$poll.pollid}">
			</td>
		</tr>
		</table>
		</form>
	</div>
	<div id="footer"></div>
</body>
</html>