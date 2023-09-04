<?php
/* Smarty version 3.1.32, created on 2019-10-04 20:03:10
  from 'C:\wamp\www\masine\admin\plg_products\proizvod\templates\index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5d97895e4fe263_99714681',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '503c2b1e5971c7998f6ee9ecde5a63e10c0a14bf' => 
    array (
      0 => 'C:\\wamp\\www\\masine\\admin\\plg_products\\proizvod\\templates\\index.tpl',
      1 => 1565883019,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d97895e4fe263_99714681 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'C:\\wamp\\www\\masine\\common\\libs\\plugins\\function.html_options.php','function'=>'smarty_function_html_options',),1=>array('file'=>'C:\\wamp\\www\\masine\\common\\libs\\plugins\\function.html_table_advanced.php','function'=>'smarty_function_html_table_advanced',),));
echo '<script'; ?>
>

	function table_plugin() {
		var link = window.folder+"/index.php";
		$("#formRecordsPerPage").change(function(){
			var rpp = $("#formRecordsPerPage option:selected").val(); 
			var param= "records_per_page=" + rpp;
			table(link,param);
		})	
	
		// editovanje polja
		$('.edit-cena').editable('plg_products/proizvod/modify_cena_final.php', {
			id: 'proizvodid',
			style: 'display:inline;',
			submit: 'OK',
			cancel: 'Poništi',
			cssclass: 'editable'
		});
		$('.edit-tezina').editable('plg_products/proizvod/modify_tezina_final.php', {
			id: 'proizvodid',
			style: 'display:inline;',
			submit: 'OK',
			cancel: 'Poništi',
			cssclass: 'editable'
		});
		
		// dodavanje u grupu proizvoda
		$(".dodaj_u_grupu").click(function() {
			var grpProizId = $(".html5buttons #grupaproizvodaid option:selected").val();
			var proizvodId = $(this).attr('data-param');
			var link = $(this).attr('data-link');
			link = window.folder+"/"+link;
			var param = "grupaproizvodaid=" + grpProizId + "&proizvodid=" + proizvodId;
			$.ajax({
				type: "POST",
				url: link,
				data: param,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);
				}
			});
		});
		// dodavanje niza proizvoda u grupu
		$("#dodaj_sve_u_grupu").click(function() {
			var grpProizId = $(".html5buttons #grupaproizvodaid option:selected").val();
			var data = {
				'proizvodid[]': [],
				'grupaproizvodaid': grpProizId
			};
			$("#tabledivbody input:checked").each(function() {
				data['proizvodid[]'].push($(this).val());
			});
			var link = $(this).attr('data-link');
            link = window.folder+"/"+link;	
			$.ajax({
				type: 'POST',
				url: link,
				data: data,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);

					$("#formTable input:checked").each(function() {
						$(this).removeAttr("checked");
					});
				}
			});
        });
		// dodavanje novog proizvoda u tip
		$("#dodajproiz").click(function() {
			var tip = $("#tipproizvodaid option:selected").val(); 
			var link = $(this).attr('data-link');
            link = window.folder+"/"+link;	
			var param = "mode=insert&tipproizvodaid="+tip;
			$.ajax({
				type: 'POST',
				url: link,
				data: param,
				success: function(data) {
					$('.backdrop').css("display", "block").html(data);
					modify_plugin();
					$('#inner .title-action #promeni').click(function() {
						var name = $(this).attr('name');
						modify(name);	
					})
				}	
			});
        });
		// selektovanje
		$("#selectall").click(function() {
			var m=0;
			if ($(this).is(":checked")) {
				$("#tabledivbody input:checkbox").each(function() {
					$(this).attr("checked", "true");
				});
			} else {
				$("#tabledivbody input:checkbox").each(function() {
					$(this).removeAttr("checked");
				});
			}
		});
		// obrisi sve selektovane
		$(".obrisi_sve_selektovane").click(function() {
			var data = {
				'proizvodid[]': []
			};
			$("#tabledivbody input:checked").each(function() {
				data['proizvodid[]'].push($(this).val());
			});
			var link = $(this).attr('data-link');
            link = window.folder+"/"+link;	

			$.ajax({
				type: 'POST',
				url: link,
				data: data,
				success: function(data) {
					var klasa = $(data).attr('class');
					toastr[klasa](data);
					var link = window.folder+"/index.php";
					var param = window.param;
					table (link,param);
				}
			});
		});
		move_rows();	
		$("#back").click(function() {
			$('a[data-class="product"]').trigger('click');
		})
	}



<?php echo '</script'; ?>
>



<div class="ibox float-e-margins">
	<div class="ibox-title">
		<div class="ibox-tools">
			<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
			</a>
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fa fa-wrench"></i>
			</a>

			<a class="close-link">
				<i class="fa fa-times"></i>
			</a>
		</div>
	</div>
	<div class="ibox-content">
		<input type="hidden" id="bproizvodid" value="<?php echo $_smarty_tpl->tpl_vars['proizvodid']->value;?>
">	
		<div class="row">
			<div class="col-lg-8">
				<div class="html5buttons">
					<div class="dt-buttons btn-group pr-buttons">
							<form name="dodajproiz"  method="POST" >
								<div class="btn btn-success buttons-html5" id="dodajproiz" data-link='modify.php' data-param='mode=insert'><i class="fa fa-plus-square-o" ></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_ADD_INTRO_TYPE']->value;?>
</span></div>
								<select name="tipproizvodaid" class="form-control" id="tipproizvodaid">
									<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['tipproizvoda_val']->value,'selected'=>$_smarty_tpl->tpl_vars['tipproizvoda_sel']->value,'output'=>$_smarty_tpl->tpl_vars['tipproizvoda_out']->value),$_smarty_tpl);?>

								</select> 
							</form>
							
							<form name="dodajugrupu" method="POST" class="html5buttons">
								<div class="btn btn-success buttons-html5 dodaj_sve_u_grupu" id="dodaj_sve_u_grupu" data-link='insert_grupa_multi.php'><i class="fa fa-plus-square-o" ></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_ADD_INTRO_GROUP']->value;?>
</span></div> <?php echo $_smarty_tpl->tpl_vars['parentgrpCmb']->value;?>

							</form>	
							<div data-link='delete_final_multi.php' class="btn btn-success buttons-html5 obrisi_sve_selektovane"><i class="fa fa-minus-square-o"></i> <span><?php echo $_smarty_tpl->tpl_vars['PLG_DELETE_SELECTED']->value;?>
</span></div>

					</div>
				</div>
			</div>
			<div class="col-lg-4 pr-rec">	
				<form name="formRecordsPerPage" id="formRecordsPerPage">
					<label class="perpage"><?php echo $_smarty_tpl->tpl_vars['PLG_RESULTS_PER_PAGE']->value;?>
 </label>
					<select class="form-control" name="records_per_page" '>
						<?php echo smarty_function_html_options(array('values'=>$_smarty_tpl->tpl_vars['recordsPerPage_val']->value,'selected'=>$_smarty_tpl->tpl_vars['recordsPerPage_sel']->value,'output'=>$_smarty_tpl->tpl_vars['recordsPerPage_out']->value),$_smarty_tpl);?>

					</select>
				</form> 
			</div>
		</div>
		
		<div class="table-responsive">
			<div id="content">
				
					<?php echo smarty_function_html_table_advanced(array('filter'=>$_smarty_tpl->tpl_vars['filter']->value,'cnt_all_rows'=>$_smarty_tpl->tpl_vars['tbl_all_rows_count']->value,'browseString'=>$_smarty_tpl->tpl_vars['tbl_browseString']->value,'scriptName'=>$_smarty_tpl->tpl_vars['scriptName']->value,'cnt_rows'=>$_smarty_tpl->tpl_vars['tbl_row_count']->value,'rowOffset'=>$_smarty_tpl->tpl_vars['tbl_offset']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tbl_tr_attributes']->value,'td_attr'=>$_smarty_tpl->tpl_vars['tbl_td_attributes']->value,'loop'=>$_smarty_tpl->tpl_vars['tbl_content']->value,'cols'=>$_smarty_tpl->tpl_vars['tbl_cols_count']->value,'tableheader'=>$_smarty_tpl->tpl_vars['tbl_header']->value,'table_attr'=>'cellspacing=0 class="index" id="normal"','exportlinks'=>$_smarty_tpl->tpl_vars['tbl_show_export_links']->value,'message'=>$_smarty_tpl->tpl_vars['poruka']->value),$_smarty_tpl);?>
		

			</div>
		</div>
	</div>
</div>

<?php echo '<script'; ?>
 language="JavaScript" type="text/JavaScript">
<?php if ($_GET['affected_categ_del']) {?>
	alert("<?php echo $_smarty_tpl->tpl_vars['PLG_SELECTION_CHANGE_CATEGORY']->value;?>
 <?php echo $_GET['affected_categ_del'];?>
.");
<?php }
if ($_GET['affected_status_arh']) {?>
	alert("<?php echo $_smarty_tpl->tpl_vars['PLG_SELECTION_CHANGE_STAUS']->value;?>
 <?php echo $_GET['affected_status_arh'];?>
.");
<?php }
echo '</script'; ?>
>

<?php }
}
